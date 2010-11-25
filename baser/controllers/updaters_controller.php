<?php
/* SVN FILE: $Id$ */
/**
 * アップデーターコントローラー
 *
 * BaserCMSのコアや、プラグインのアップデートを行えます。
 *
 * ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
 * 　アップデートファイルの配置場所
 * ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
 * ■ コア
 * /baser/config/update/{バージョン番号}/
 * ■ baserフォルダ内プラグイン
 * /baser/plugins/{プラグイン名}/update/{バージョン番号}/
 * ■ appフォルダ内プラグイン
 * /app/plugins/{プラグイン名}/update/{バージョン番号}/
 *
 * ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
 * 　アップデートスクリプト
 * ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
 * アップデート処理実行時に実行されるスクリプトです。
 * スキーマファイルやCSVファイルを読み込む関数が利用可能です。
 * 次のファイル名で対象バージョンのアップデートフォルダに設置します。
 *
 * ■ ファイル名： updater.php
 *
 * ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
 * 　スキーマファイル
 * ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
 * データベースの構造変更にCakeSchemaを利用できます。
 * ブラウザより、次のURLにアクセスするとスキーマファイルの書き出しが行えますのでそれを利用します。
 * http://{BaserCMSの設置URL}/admin/tools/write_schema
 * 更新タイプによって、ファイル名を変更し、アップデートフォルダに設置します。
 *
 * ■ テーブル追加： create_{テーブル名}.php
 * ■ テーブル更新： alter_{テーブル名}.php
 * ■ テーブル削除： drop_{テーブル名}.php
 * ※ ファイル名に更新タイプを含めない場合は、createとして処理されます。
 *
 * ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
 * 　CSVファイル
 * ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
 * CSVファイルによってデータのインポートが行えます。
 * CSVファイルはShift-JISで作成します。
 * 1行目には必ずフィールド名が必要です。
 * PRIMARYKEY のフィールドを自動採番するには、1行目のフィールド名は設定した上で値を空文字にします。
 * 次のファイル名で対象バージョンのアップデートフォルダに設置します。
 *
 * ■ ファイル名： {テーブル名}.php
 *
 * ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
 * 　アップデート用関数
 * ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
 * アップデートプログラム上で利用できる関数は次のとおりです。
 *
 * ----------------------------------------
 * 　スキーマファイルを読み込む
 * ----------------------------------------
 * $this->loadSchema($version, $plugin = '', $filterTable = '', $filterType = '');
 *
 * $version			アップデート対象のバージョン番号を指定します。（例）'1.6.7'
 * $plugin			プラグイン内のスキーマを読み込むにはプラグイン名を指定します。（例）'mail
 * $filterTable		指定したテーブルのみを追加・更新する場合は、プレフィックスを除外したテーブル名を指定します。（例）'permissions'
 *					指定しない場合は全てのスキーマファイルが対象となります。
 * $filterType		指定した更新タイプ（create / alter / drop）のみを対象とする場合は更新タイプを指定します。（例）'create'
 *					指定しない場合はスキーマファイルが対象となります。
 *
 * ----------------------------------------
 * 　CSVファイルを読み込む
 * ----------------------------------------
 * $this->loadCsv($version, $plugin = '', $filterTable = '');
 * $version			アップデート対象のバージョン番号を指定します。（例）'1.6.7'
 * $plugin			プラグイン内のCSVを読み込むにはプラグイン名を指定します。（例）'mail'
 * $filterTable		指定したテーブルのみCSVを読み込む場合は、プレフィックスを除外したテーブル名を指定します。（例）'permissions'
 *					指定しない場合は全てのテーブルが対象になります。
 *
 * ----------------------------------------
 * 　アップデートメッセージをセットする
 * ----------------------------------------
 * アップデート完了時に表示するメッセージを設定します。ログにも記録されます。
 * ログファイルの記録場所：/app/tmp/logs/update.log
 *
 * $this->setMessage($message, $strong = false, $head = false, $beforeBreak = false);
 *
 * $message			メッセージを指定します。
 * $strong			強調タグを付加します。
 * $head			見出しとしてメッセージを指定する場合は true を指定します。
 * $beforeBreak		設定するメッセージの直前に空白行を挿入する場合には true を指定します。
 *
 * ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
 * 　開発時のテストについて
 * ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
 * 次期バージョンのアップデートスクリプトを作成する際のテストを行うには、
 * アップデートフォルダの名称をバージョン番号ではなく、「test」とすると、
 * WEBサイトのバージョンが更新されず、何度もテストを行えます。
 * ※ アップデートによって変更された内容のリセットは手動で行う必要があります。
 *
 * ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
 * 　スキーマの読み込みテストについて
 * ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
 * 作成したスキーマファイルが正常に読み込めるかをテストする場合には、
 * ブラウザより次のURLにアクセスし、スキーマファイルをアップロードしてテストを行なえます。
 *
 * http://{BaserCMSの設置フォルダ}/admin/tools/load_schema
 *
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
 * @package			cake
 * @subpackage		cake.app.controllers
 * @since			Baser v 0.1.0
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://basercms.net/license/index.html
 */
/**
 * Include files
 */
/**
 * アップデーターコントローラー
 */
class UpdatersController extends AppController {
/**
 * クラス名
 *
 * @var		string
 * @access	public
 */
	var $name = 'Updaters';
/**
 * アップデートメッセージ
 *
 * @var		string
 * @access	protected
 */
	var $_updateMessage = array();
/**
 * コンポーネント
 *
 * @var     array
 * @access  public
 */
	var $components = array('Auth', 'Cookie', 'AuthConfigure');
/**
 * モデル
 *
 * @var		array
 * @access	public
 */
	var $uses = array('Updater', 'Plugin');
/**
 * beforeFilter
 *
 * @return	void
 * @access	public
 */
	function beforeFilter() {
		$this->layoutPath = 'admin';
		$this->layout = 'default';
		$this->subDir = 'admin';
	}
/**
 * コアのアップデート実行
 *
 * @return void
 * @access public
 */
	function admin_index() {

		clearAllCache();

		$targets = array('', 'blog', 'feed', 'mail');

		$scriptNum = 0;
		foreach($targets as $target) {
			$scriptNum += $this->_getScriptNum($target);
		}

		/* スクリプト実行 */
		if($this->data) {
			$this->setMessage('アップデート処理を開始します。', false, true, true);
			foreach($targets as $target) {
				if(!$this->_update($target)){
					$this->setMessage('アップデート処理が途中で失敗しました。', true);
				}
			}
			$this->setMessage('全てのアップデート処理が完了しました。', false, true, true);
			$this->Session->setFlash($this->_getUpadteMessage());
			$this->_writeUpdateLog();
			$this->redirect(array('action'=>'index'));

		}

		$targetVersion = $this->getBaserVersion();
		$sourceVersion = $this->getSiteVersion();
		$this->pageTitle = 'BaserCMSコア アップデート';
		$this->set('updateTarget', 'BaserCMSコア');
		$this->set('siteVer',$sourceVersion);
		$this->set('baserVer',$targetVersion);
		$this->set('scriptNum',$scriptNum);
		$this->set('plugin', false);
		$this->render('update');

	}
/**
 * コアのアップデート実行
 *
 * @return void
 * @access public
 */
	function admin_plugin($name) {

		if(!$name) {
			$this->notFound();
		}
		$title = $this->Plugin->field('title',array('name'=>$name));
		if(!$title) {
			$this->notFound();
		}

		clearAllCache();

		/* スクリプトの有無を確認 */
		$scriptNum = $this->_getScriptNum($name);

		/* スクリプト実行 */
		if($this->data) {

			$this->_update($name);
			$this->Session->setFlash($this->_getUpadteMessage());
			$this->_writeUpdateLog();
			$this->redirect(array('action'=>'plugin', $name));

		}

		$targetVersion = $this->getBaserVersion($name);
		$sourceVersion = $this->getSiteVersion($name);
		$title = $this->Plugin->field('title',array('name'=>$name)).'プラグイン';
		$this->pageTitle = $title.' アップデート';
		$this->set('updateTarget', $title);
		$this->set('siteVer',$sourceVersion);
		$this->set('baserVer',$targetVersion);
		$this->set('scriptNum',$scriptNum);
		$this->set('plugin', $name);
		$this->render('update');

	}
/**
 * 処理対象のスクリプト数を取得する
 *
 * @param	string	$plugin
 * @return	int
 * @access	protected
 */
	function _getScriptNum($plugin= '') {

		/* バージョンアップ対象のバージョンを取得 */
		$targetVersion = $this->getBaserVersion($plugin);
		$sourceVersion = $this->getSiteVersion($plugin);

		/* スクリプトの有無を確認 */
		$scriptNum = count($this->_getUpdaters($sourceVersion, $targetVersion, $plugin));
		return $scriptNum;

	}
/**
 * アップデータのパスを取得する
 *
 * @param	string	$sourceVersion
 * @param	string	$targetVersion
 * @param	string	$plugin
 * @return	array	$updates
 * @access	protected
 */
	function _getUpdaters($sourceVersion, $targetVersion, $plugin = ''){

		$sourceVerPoint = verpoint($sourceVersion);
		$targetVerPoint = verpoint($targetVersion);

		if(!$plugin) {
			$path = BASER_CONFIGS.'update'.DS;
			if(!is_dir($path)){
				return array();
			}
		}else{
			$appPath = APP.'plugins'.DS.$plugin.DS.'config'.DS.'update'.DS;
			$baserPath = BASER_PLUGINS.$plugin.DS.'config'.DS.'update'.DS;
			if(is_dir($appPath)){
				$path = $appPath;
			} elseif(is_dir($baserPath)) {
				$path = $baserPath;
			}else {
				return array();
			}
		}

		$folder = new Folder($path);
		$files = $folder->read(true,true);
		$updaters = array();
		if(!empty($files[0])) {
			foreach ($files[0] as $folder) {
				$updateVersion = $folder;
				$updateVerPoint = verpoint($updateVersion);
				if(($updateVerPoint > $sourceVerPoint && $updateVerPoint <= $targetVerPoint) || $updateVersion=='test') {
					if(file_exists($path.DS.$folder.DS.'updater.php')) {
						$updaters[$updateVersion] = $updateVerPoint;
					}
				}
			}
		}
		return $updaters;

	}
/**
 * アップデートフォルダのパスを取得する
 *
 * @param	string	$plugin
 * @return	mixed	$path or false
 * @access	protected
 */
	function _getUpdateFolder($plugin='') {
		if(!$plugin) {
			return BASER_CONFIGS.'update'.DS;
		} else {
			$appPath = APP.'plugins'.DS.$plugin.DS.'config'.DS.'update'.DS;
			$baserPath = BASER_PLUGINS.$plugin.DS.'config'.DS.'update'.DS;
			if(is_dir($appPath)) {
				return $appPath;
			} elseif(is_dir($baserPath)) {
				return $baserPath;
			} else {
				return false;
			}
		}
	}
/**
 * アップデートを実行する
 *
 * アップデートスクリプトを読み込む為、
 * よく使われるような変数名はダブらないように
 * アンダースコアを二つつける
 *
 * @param	string	$targetVersion
 * @param	string	$sourceVersion
 * @param	string	$plugin
 * @return	boolean
 * @access	public
 */
	function _update($__plugin = '') {

		$targetVersion = $this->getBaserVersion($__plugin);
		$sourceVersion = $this->getSiteVersion($__plugin);
		$__path = $this->_getUpdateFolder($__plugin);
		$updaters = $this->_getUpdaters($sourceVersion, $targetVersion, $__plugin);

		if(!$__plugin) {
			$__name = 'BaserCMSコア';
		}else{
			$__name = $this->Plugin->field('title',array('name'=>$__plugin)).'プラグイン';
		}

		$this->setMessage($__name.' '.$targetVersion.' へのアップデートを開始します。', false, true, true);

		if($updaters){
			asort($updaters);
			foreach($updaters as $__version => $updateVerPoint) {
				$this->setMessage('アップデートプログラム '.$__version.' を実行します。', false, true, true);
				include $__path.$__version.DS.'updater.php';
			}
		}

		if(!isset($updaters['test'])) {
			if(!$__plugin) {
				/* サイト基本設定にバージョンを保存 */
				$SiteConfigClass = ClassRegistry::getObject('SiteConfig');
				$__data['SiteConfig']['version'] = $targetVersion;
				$__result = $SiteConfigClass->saveKeyValue($__data);
			} else {
				$__data = $this->Plugin->find('first', array('conditions'=>array('name'=>$__plugin)));
				$__data['Plugin']['version'] = $targetVersion;
				$__result = $this->Plugin->save($__data);
			}
		} else {
			$__result = true;
		}

		$this->setMessage($__name.' '.$targetVersion.' へのアップデートが完了しました。', false, true, true);

		return $__result;

	}
/**
 * アップデートメッセージをセットする
 *
 * @param	string		$message
 * @param	boolean		$head			見出しとして設定する
 * @param	boolean		$beforeBreak	前の行で改行する
 * @return	void
 * @access	public
 */
	function setMessage($message, $strong = false, $head = false, $beforeBreak = false) {
		if($beforeBreak) {
			$this->_updateMessage[] = '';
		}
		if($head){
			$message = '■ '.$message;
		}else{
			$message = '　　* '.$message;
		}
		if($strong) {
			$message = '<strong>'.$message.'</strong>';
		}
		$this->_updateMessage[] = $message;
	}
/**
 * DB構造を変更する
 *
 * @param	string	$version
 * @param	string	$plugin
 * @param	string	$filterTable
 * @param	string	$filterType
 * @return	boolean
 * @access	public
 */
	function loadSchema($version, $plugin = '', $filterTable = '', $filterType = '') {

		$path = $this->_getUpdatePath($version, $plugin);
		if(!$path) {
			return false;
		}
		$result = $this->Updater->loadSchema('baser', $path, $filterTable, $filterType, array('updater.php'));
		clearAllCache();
		return $result;

	}
/**
 * データを追加する
 *
 * @param	string	$version
 * @param	string	$plugin
 * @param	string	$filterTable
 * @return	boolean
 * @access	public
 */
	function loadCsv($version, $plugin = '', $filterTable = '') {

		$path = $this->_getUpdatePath($version, $plugin);
		if(!$path) {
			return false;
		}
		return $this->Updater->loadCsv('baser', $path, $filterTable);

	}
/**
 * アップデートスクリプトのパスを取得する
 *
 * @param	string	$version
 * @param	string	$plugin
 * @return	string	$path or ''
 */
	function _getUpdatePath($version, $plugin = '') {

		$path = '';
		$appPluginPath = APP.'plugins'.DS.$plugin.DS.'config'.DS.'update'.DS.$version;
		$baserPluginPath = BASER_PLUGINS.$plugin.DS.'config'.DS.'update'.DS.$version;
		$corePath = BASER_CONFIGS.'update'.DS.$version;
		if($plugin) {
			if(is_dir($appPluginPath)) {
				$path = $appPluginPath;
			} elseif($baserPluginPath) {
				$path = $baserPluginPath;
			} else {
				return false;
			}
		} else {
			if(is_dir($corePath)) {
				$path = $corePath;
			} else {
				return false;
			}
		}
		return $path;

	}
/**
 * アップデートメッセージを取得する
 * 改行区切り
 * @return string
 */
	function _getUpadteMessage() {
		return implode('<br />',$this->_updateMessage);
	}
/**
 * アップデートメッセージを保存する
 *
 * @return	void
 * @access	protected
 */
	function _writeUpdateLog() {
		if($this->_updateMessage) {
			foreach($this->_updateMessage as $message) {
				$this->log(strip_tags($message), 'update');
			}
		}
	}

}
?>