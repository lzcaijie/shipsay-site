<?php
require_once '../header.php';
include_once $config_file=__ROOT_DIR__.'/shipsay/configs/search.ini.php';
?>
<div class="layui-body">
   <form class="layui-form layui-form-pane" method="POST" action="javascript:;">
       <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief" style="margin-top: 6px;">
           <ul class="layui-tab-title">
               <li class="layui-this">搜索记录( 全网 )</li>
               <li>参数设置( 本站 )</li>
           </ul>
           <div class="layui-tab-content" style="height: 100px;">
               <div class="layui-tab-item layui-show">
                   <fieldset class="layui-elem-field layui-field-title">
                       <legend>搜索记录( 全网 )</legend>
                   </fieldset>
                   <table class="layui-hide" id="searchList" lay-filter="searchList"></table>
               </div>

               <div class="layui-tab-item">
                   <fieldset class="layui-elem-field layui-field-title">
                       <legend>搜索参数设置( 本站 )</legend>
                   </fieldset>

                   <div class="layui-form-item">
                       <label class="layui-form-label">搜索间隔</label>
                       <div class="layui-input-inline">
                           <input type="text" name="delay" value="<?=$ShipSaySearch['delay']?:30?>" autocomplete="off" class="layui-input">
                       </div>
                       <div class="layui-form-mid layui-word-aux">( 秒 ) 两次搜索之间的间隔, <b style="color:#FF5722">0 = 禁止搜索</b></div>
                   </div>

                   <div class="layui-form-item">
                       <label class="layui-form-label">最多结果数</label>
                       <div class="layui-input-inline">
                           <input type="text" name="limit" value="<?=$ShipSaySearch['limit']?:100?>" autocomplete="off" class="layui-input">
                       </div>
                       <div class="layui-form-mid layui-word-aux">最多返回的搜索结果数, 数值越低, 源站负载越小</div>
                   </div>

                   <div class="layui-form-item">
                       <label class="layui-form-label">最少长度</label>
                       <div class="layui-input-inline">
                           <input type="text" name="min_words" value="<?=$ShipSaySearch['min_words']?:2?>" autocomplete="off" class="layui-input">
                       </div>
                       <div class="layui-form-mid layui-word-aux">搜索关键字最少长度</div>
                   </div>

                   <div class="layui-form-item">
                       <label class="layui-form-label">缓存时间</label>
                       <div class="layui-input-inline">
                           <input type="text" name="cache_time" value="<?=$ShipSaySearch['cache_time']?:86400?>" autocomplete="off" class="layui-input">
                       </div>
                       <div class="layui-form-mid layui-word-aux">( 秒 ) 将搜索结果集缓存, 时间越长, 源站负载越小</div>
                   </div>

                   <div class="layui-form-item">
                       <label class="layui-form-label">搜索记录</label>
                       <div class="layui-input-inline">
                           <input type="radio" name="is_record" value="0" title="关闭" <?php if($ShipSaySearch['is_record']==0): ?> checked="" <?php endif ?>>
                           <input type="radio" name="is_record" value="1" title="开启" <?php if($ShipSaySearch['is_record']==1): ?> checked="" <?php endif ?>>
                       </div>
                       <div class="layui-form-mid layui-word-aux">是否将搜索记录写入数据库 ( 关闭可降低负载 )</div>
                   </div>

                   <blockquote class="layui-elem-quote layui-text">
                       1 小时 = 3600 秒 ; 1 天 = 86400 秒
                   </blockquote>
               </div>
           </div>
       </div>
   </form>
</div>
<div class="layui-footer">
   <button class="layui-btn save-btn-search">保存设置</button><span class="layui-word-aux">所有设置均为英文半角,结尾不加 /</span>
   <span class="layui-layout-right layui-word-aux" style="margin-right: 10px;">&copy; 船说CMS</span>
</div>

</div> <!-- /header -->

<script type="text/html" id="toolbarDemo">
   <!-- 表头模板 -->
<div class="layui-btn-container">
   <button class="layui-btn layui-btn-sm" lay-event="delCheckData">删除选中数据</button>
   <button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="delAll">清空全部数据</button>
</div>
</script>

<script>
   layui.use('table', function() {

       let table = layui.table;

       table.render({
           elem: '#searchList',
           url: '../include/search.php?do=show',
           toolbar: '#toolbarDemo' //开启头部工具栏，并为其绑定左侧模板
               ,
           limit: 20,
           defaultToolbar: ['filter', 'exports', 'print'],
           cols: [
               [
                   // {field:'searchid', title:'ID', width:50, fixed: 'left'}
                   {
                       type: 'checkbox',
                       fixed: 'left'
                   }, {
                       field: 'keywords',
                       title: '关键字',
                       sort: true
                   }, {
                       field: 'results',
                       title: '结果数',
                       width: 100
                   }, {
                       field: 'searchsite',
                       title: '来源',
                       sort: true
                   }, {
                       field: 'searchtime',
                       title: '时间',
                       sort: true
                   }
               ]
           ],
           page: true
       });

       //头工具栏事件
       table.on('toolbar(searchList)', function(obj) {
           let checkStatus = table.checkStatus(obj.config.id);
           let data = checkStatus.data;
           switch (obj.event) {
               case 'delCheckData':
                   layer.confirm('确定要删除选中数据吗？', function() {
                       let ids = [];
                       $.each(data, function(index, value) {
                           ids.push(value.searchid);
                       })

                       $.ajax({
                           type: "POST",
                           url: "../include/search.php",
                           data: {
                               "do": "delete",
                               "searchid": ids
                           },
                           success: function(state) {
                               layer.msg(state == 200 ? '删除成功' : '删除失败,请检查配置');
                           }
                       })
                       table.reload('searchList');
                   })
                   break;

               case 'delAll':
                   layer.confirm('确定要清空搜索记录吗？', function() {
                       $.ajax({
                           type: "POST",
                           url: "../include/search.php",
                           data: {
                               "do": "delAll",
                           },
                           success: function(state) {
                               layer.msg(state == 200 ? '清空成功' : '失败,请检查配置');
                           }
                       })
                       table.reload('searchList');
                   })
           }
       })

   })

   $('.save-btn-search').on('click', function() {
       $.ajax({
           type: "POST",
           url: "/<?=$admin_url?>/savecfgs.php?do=search",
           data: {
               "delay": $("input[name='delay']").val(),
               "limit": $("input[name='limit']").val(),
               "min_words": $("input[name='min_words']").val(),
               "cache_time": $("input[name='cache_time']").val(),
               "is_record": $("input[name='is_record']:checked").val(),
               "config_file": "<?=$config_file?>"
           },
           async: true,
           success: function(state) {
               layer.msg(state == 200 ? '保存成功' : '保存失败,请检查配置');
           }
       })
   })

   layui.use(['element', 'form'], function() {
       let element = layui.element;
       let form = layui.form;
       form.render();
   })
</script>

</body>

</html>