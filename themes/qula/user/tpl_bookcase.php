<?php if (!defined('__ROOT_DIR__')) exit; ?>

<!DOCTYPE html>
<html lang='zh'>
<head>
<meta charset="UTF-8">
<title>永久书架_<?=SITE_NAME?></title>

<?php require_once __THEME_DIR__  . '/tpl_header.php'; ?>

<div class="container">
        <div class="history-box">
            <table class="history-table">
                <caption>用户书架 - 收藏过的小说会同步到该列表中</caption>
                <thead>
                    <tr>
                        <th>序号</th>
                        <th>小说名称</th>
                        <th class="xs-hidden">作者</th>
                        <th class="xs-hidden">最新章节</th>
                        <th>上次阅读章节</th>
                        <th class="xs-hidden">更新时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                      <?php foreach($caseArr as $k => $v): ?>
                    <tr>
                        <td><?=$k+1?></td>
                        <td><a href="<?=$v['info_url']?>"><?=$v['articlename']?></a> </td>
                      
                         <td class="xs-hidden"><?=$v['author']?></td>
                           <td ><a href="<?=$v['last_url']?>"><?=$v['lastchapter']?></a></td>
                        <td class="xs-hidden"><a href="<?php if($v['chaptername'] !=''): ?><?=$v['case_url']?><?php endif ?>"><?php if($v['chaptername'] !=''): ?><?=$v['chaptername']?><?php endif ?> </td>
                   
                        <td class="xs-hidden"><?=date('Y-m-d',$v['lastupdate'])?></td>
                        <td><a href="javascript:;" onclick="delbookcase('<?=$v['articleid']?>');">删除</a> </td>
                    </tr>
                      <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

           
        </div>
    </div>
</div>

<?php require_once __THEME_DIR__  . '/tpl_footer.php'; ?>