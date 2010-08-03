<?php
/* SVN FILE: $Id$ */
/**
 * ブログ最近の投稿ウィジェット設定
 *
 * PHP versions 4 and 5
 *
 * BaserCMS :  Based Website Development Project <http://basercms.net>
 * Copyright 2008 - 2010, Catchup, Inc.
 *								9-5 nagao 3-chome, fukuoka-shi
 *								fukuoka, Japan 814-0123
 *
 * @copyright		Copyright 2008 - 2010, Catchup, Inc.
 * @link			http://basercms.net BaserCMS Project
 * @package			baser.plugins.blog.views
 * @since			Baser v 0.1.0
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://basercms.net/license/index.html
 */
$title = '最近の投稿';
$description = 'ブログの最近の投稿を表示します。';
?>
<?php echo $formEx->label($key.'.blog_content_id','ブログ') ?>&nbsp;
<?php echo $formEx->select($key.'.blog_content_id',$formEx->getControlSource('Blog.BlogContent.id'),null,null,false) ?><br />
<small>ブログページを表示している場合は、上記の設定に関係なく、対象ブログの最近の投稿を表示します。</small>