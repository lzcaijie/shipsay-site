<form class="layui-form layui-form-pane" method="POST" action="javascript:;">
   <fieldset class="layui-elem-field layui-field-title">
       <legend>长尾词设置 ( 注意: 长尾词小说的路径不支持拼音路径 )</legend>
   </fieldset>

   <div class="layui-form-item">
       <label class="layui-form-label">长尾词开关</label>
       <div class="layui-input-inline switch-wd">
           <input type="checkbox" name="is_langtail" lay-skin="switch" lay-filter="is_langtail" lay-text="ON|OFF" <?php if($is_langtail==1)echo ' checked' ?>>
       </div>
       <div class="layui-form-mid layui-word-aux"><b style="color:#FF5722">( 此功能需单独购买 )</b></div>
   </div>

   <div class="layui-form-item">
       <label class="layui-form-label">抓取周期</label>
       <div class="layui-input-inline">
           <input type="text" name="langtail_catch_cycle" value="<?=$langtail_catch_cycle?:7?>" autocomplete="off" class="layui-input">
       </div>
       <div class="layui-form-mid layui-word-aux">( 天 ) , 从百度长尾词API接口重新抓取的周期 </div>
   </div>

   <div class="layui-form-item">
       <label class="layui-form-label">缓存时间</label>
       <div class="layui-input-inline">
           <input type="text" name="langtail_cache_time" value="<?=$langtail_cache_time?:0?>" autocomplete="off" class="layui-input">
       </div>
       <div class="layui-form-mid layui-word-aux">( 秒 ) , 依赖 Redis , 0=不缓存 </div>
   </div>


   <div class="layui-form-item">
       <label class="layui-form-label">长尾信息页</label>
       <div class="layui-input-inline" style="width:300px;">
           <input type="text" name="fake_langtail_info" value="<?=$fake_langtail_info?>" autocomplete="off" class="layui-input">
       </div>
       <div class="layui-form-mid layui-word-aux"> <b style="color:#FF5722">{aid}</b> 小说ID , <b style="color:#FF5722">{subaid}</b>小说子序号(可选)</div>
   </div>

   <div class="layui-form-item">
       <label class="layui-form-label">长尾目录页</label>
       <div class="layui-input-inline" style="width:300px;">
           <input type="text" name="fake_langtail_indexlist" value="<?=$fake_langtail_indexlist?>" autocomplete="off" class="layui-input">
       </div>
       <div class="layui-form-mid layui-word-aux"><b style="color:#FF5722">{aid}</b> 小说ID , <b style="color:#FF5722">{subaid}</b>小说子序号(可选) , <b style="color:#FF5722">{pid}</b>翻页码(必填) </div>
   </div>


   <fieldset class="layui-elem-field layui-field-title">
       <legend>关键字 ( 标签 ) 设置</legend>
   </fieldset>

   <div class="layui-form-item">
       <label class="layui-form-label">关键字开关</label>
       <div class="layui-input-inline switch-wd">
           <input type="checkbox" name="is_keywords" lay-skin="switch" lay-filter="is_keywords" lay-text="ON|OFF" <?php if($is_keywords==1)echo ' checked' ?>>
       </div>
       <div class="layui-form-mid layui-word-aux"><b style="color:#FF5722">( 此功能需单独购买 )</b></div>
   </div>

   <div class="layui-form-item">
       <label class="layui-form-label">最大数量</label>
       <div class="layui-input-inline">
           <input type="text" name="keywords_num" value="<?=$keywords_num?:5?>" autocomplete="off" class="layui-input">
       </div>
       <div class="layui-form-mid layui-word-aux">自动生成关键字 ( 标签 ) 的数量, 也是前台显示的数量. </div>
   </div>

   <div class="layui-form-item">
       <label class="layui-form-label">列表页url</label>
       <div class="layui-input-inline">
           <input readonly type="text" name="fake_tag" value="/tag/{tag}/{pid}.html" autocomplete="off" class="layui-input">
       </div>
       <div class="layui-form-mid layui-word-aux"><b style="color:#FF5722">{tag}</b> 关键字 , <b style="color:#FF5722">{pid}</b>翻页码(必填) </div>
   </div>
</form>