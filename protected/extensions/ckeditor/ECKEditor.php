<?php
class ECKEditor extends CInputWidget
{
	const COLS = 40;
	const ROWS = 16;

	public $ufolder = '';

	private $language = 'en';

	private $allowedLanguages = array(
		'af','ar','bg','bn','bs','ca','cs','da','de','el','en','en-au','en-ca',
		'en-uk','eo','es','et','eu','fa','fi','fo','fr','fr-ca','gl','gu','he',
		'hi','hr','hu','is','it','ja','km','ko','lt','lv','mn','ms','nb','nl',
		'no','pl','pt','pt-br','ro','ru','sk','sl','sr','sr-latn','sv','th','tr',
		'uk','vi','zh','zh-cn'
	);

	private $options = array();

	private $allowedEditorTemplates = array('full','basic','control','editor','comments');
	private $editorTemplate = 'full';
	private $plugins = array();
	private $contentCSS = '';
	private $width = '100%';
	private $height = '400px';

	private $fontFamilies = array(
		'Arial'=>'Arial, Helvetica, sans-serif', 
		'Comic Sans MS'=>'Comic Sans MS, cursive',
		'Courier New'=>'Courier New, Courier, monospace',
		'Georgia'=>'Georgia, serif',
		'Lucida Sans Unicode'=>'Lucida Sans Unicode, Lucida Grande, sans-serif',
		'Tahoma'=>'Tahoma, Geneva, sans-serif',
		'Times New Roman'=>'Times New Roman, Times, serif',
		'Trebuchet MS'=>'Trebuchet MS, Helvetica, sans-serif',
		'Verdana'=>'Verdana, Geneva, sans-serif',
	);

	private $fontSizes = array(
		'8'=>'8px',
		'9'=>'9px',
		'10'=>'10px',
		'11'=>'11px',
		'12'=>'12px',
		'14'=>'14px',
		'16'=>'16px',
		'18'=>'18px',
		'20'=>'20px',
		'22'=>'22px',
		'24'=>'24px',
		'26'=>'26px',
		'28'=>'28px',
		'36'=>'36px',
		'48'=>'48px',
		'72'=>'72px'
	);

	private $toolbar = array();
	public $skin = 'moono';
	private $theme = 'default';
	public $config_file = '';

	public function  __construct($owner=null)
	{
		parent::__construct($owner);
		$this->setLanguage(Yii::app()->language);
	}

	public function setLanguage($value)
	{
		$lang = (($p = strpos($value, '_')) !== false) ? str_replace('_', '-', $value) : $value;
		if (in_array($lang, $this->allowedLanguages)){
			$this->language = $lang;
		}else{
			$suffix = empty($lang) ? 'en' : ($p !== false) ? strtolower(substr($lang, 0, $p)) : strtolower($lang);
			if (in_array($suffix, $this->allowedLanguages)) $this->language = $suffix;
		}
		if(isset($this->allowedLanguages[$lang]))
			$this->language=$lang;
	}

	public function getLanguage()
	{
		return $this->language;
	}

	public function setOptions($value)
	{
		if (!is_array($value))
			throw new CException(Yii::t(__CLASS__, 'options must be an array'));

		$this->options=$value;
	}

	public function getOptions()
	{
		return $this->options;
	}

	public function setHeight($value)
	{
		if (!preg_match("/[\d]+[px|\%]/", $value))
			throw new CException(Yii::t(__CLASS__, 'height must be a string of digits terminated by "%" or "px"'));
		$this->height = $value;
	}

	public function getHeight()
	{
		return $this->height;
	}

	public function setWidth($value)
	{
		if (!preg_match("/[\d]+[px|\%]/", $value))
			throw new CException(Yii::t('ETinyMce', 'width must be a string of digits terminated by "%" or "px"'));
		$this->width = $value;
	}

	public function getWidth()
	{
		return $this->width;
	}

	public function setFontFamilies($value)
	{
		if (!is_array($value))
			throw new CException(Yii::t(__CLASS__, 'fontFamilies must be an array of strings'));
		$this->fontFamilies = $value;
	}

	public function getFontFamilies()
	{
		return $this->fontFamilies;
	}

	public function setFontSizes($value)
	{
		if (!is_array($value))
			throw new CException(Yii::t(__CLASS__, 'fontSizes must be an array of integers'));
		$this->fontSizes = $value;
	}

	public function getFontSizes()
	{
		return $this->fontSizes;
	}

	public function setEditorTemplate($value)
	{
		if (!in_array($value, $this->allowedEditorTemplates))
			throw new CException(Yii::t(__CLASS__, 'editorTemplate must be one of {temp}', array('{temp}'=>implode(',', $this->validEditorTemplates))));
		$this->editorTemplate = $value;
	}

	public function getEditorTemplate()
	{
		return $this->editorTemplate;
	}

	public function setPlugins($value)
	{
		if (!is_array($value))
			throw new CException(Yii::t(__CLASS__, 'plugins must be an array of strings'));
		$this->plugins = $value;
	}

	public function getPlugins()
	{
		return $this->plugins;
	}

	public function setContentCSS($value)
	{
		if (!is_string($value))
			throw new CException(Yii::t(__CLASS__, 'contentCSS must be an URL'));
		$this->contentCSS = $value;
	}

	public function getContentCSS()
	{
		return $this->contentCSS;
	}

	public function setToolbar($value)
	{
		if(is_array($value)||is_string($value))
		{
			$this->toolbar=$value;
		}
		else
			throw new CException(Yii::t(__CLASS__, 'toolbar must be an array or string'));
	}

	public function getToolbar()
	{
		return $this->toolbar;
	}

	public function setSkin($value)
	{
		if (!is_string($value))
			throw new CException(Yii::t(__CLASS__, 'Skin must be a string'));
		$this->skin = $value;
	}

	public function getSkin()
	{
		return $this->skin;
	}

	public function setTheme($value)
	{
		if (!is_string($value))
			throw new CException(Yii::t(__CLASS__, 'Theme must be a string'));
		$this->theme = $value;
	}

	public function getTheme()
	{
		return $this->theme;
	}

	protected function makeOptions()
	{
		list($name,$id) = $this->resolveNameID();

		$options['language'] = $this->language;

		if ($this->contentCSS !== '')
		{
			$options['contentsCss'] = $this->contentCSS;
		}

		switch ($this->editorTemplate)
		{
			case 'full':
			{
				$options['toolbar'] = 'Full';
				$_SESSION['KCFINDER']['disabled'] = true;
				break;
			}
			case 'basic':
			{
				$options['toolbar'] = 'Basic';
				$options['toolbar_Basic']=array(
					array('name'=>'basicstyles','items'=>array('Bold','Italic','Underline','Strike','-','RemoveFormat')),
				);
				$_SESSION['KCFINDER']['disabled'] = true;
				break;
			}
			case 'control':
			{
				// панель кнопок
				$options['toolbar']=array(
					array('name'=>'document','items'=>array('Source','-','ShowBlocks','-','Maximize','Preview')),
					array('name'=>'clipboard','items'=>array('Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo')),
					array('name'=>'insert','items'=>array('Image','Flash','Table','HorizontalRule','SpecialChar')),
					'/',
					array('name'=>'basicstyles','items'=>array('Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat')),
					array('name'=>'paragraph','items'=>array('NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock')),
					array('name'=>'links','items'=>array('Link','Unlink','Anchor')),
					'/',
					array('name'=>'styles','items'=>array('Styles','Format','Font','FontSize')),
					array('name'=>'colors','items'=>array('TextColor','BGColor')),
				);
				// css отображение
				$options['contentsCss'] = '/css/ckeditor/control.css';
				// папка для загруски изображений
				if (Yii::app()->user->checkAccess(Users::ROLE_MODER))
				{
					$path = Yii::getPathOfAlias('webroot.upload.userfiles').DIRECTORY_SEPARATOR;
					if (file_exists($path))
					{
						$_SESSION['KCFINDER']['disabled'] = false;
						$_SESSION['KCFINDER']['uploadURL'] = Yii::app()->baseUrl."/upload/userfiles/";
						$_SESSION['KCFINDER']['uploadDir'] = $_SERVER['DOCUMENT_ROOT']."/upload/userfiles/";
					}
					else
						$_SESSION['KCFINDER']['disabled'] = true;
				}
				else
					$_SESSION['KCFINDER']['disabled'] = true;
				// опции для файлменеджера
				$baseDir = Yii::app()->baseUrl.'/protected/extensions/ckeditor';
				$options['filebrowserBrowseUrl'] = $baseDir."/kcfinder/browse.php?type=files";
				$options['filebrowserImageBrowseUrl'] = $baseDir."/kcfinder/browse.php?type=images";
				$options['filebrowserFlashBrowseUrl'] = $baseDir."/kcfinder/browse.php?type=flash";
				$options['filebrowserUploadUrl'] = $baseDir."/kcfinder/upload.php?type=files";
				$options['filebrowserImageUploadUrl'] = $baseDir."/kcfinder/upload.php?type=images";
				$options['filebrowserFlashUploadUrl'] = $baseDir."/kcfinder/upload.php?type=flash";
				// дополнительные опции
				$options['allowedContent'] = array(
					'strong em b i u s ul ol big small tt code q sub sup hr img object embed param p h1 h2 h3 h4 h5 h5 h6 li pre address div table tr th td caption tbody thead span a'=>array(
						'attributes'=>'*',
						'classes'=>'*',
						'styles'=>'*',
					),
				);
				$options['stylesSet'] = array(
					/*array('name'=>'Заметка','element'=>'p','attributes'=>array('class'=>'note')),
					array('name'=>'Заметка (слева)','element'=>'p','attributes'=>array('class'=>'note-left')),
					array('name'=>'Заметка (справа)','element'=>'p','attributes'=>array('class'=>'note-right')),
					array('name'=>'Цитата','element'=>'p','attributes'=>array('class'=>'blockquote')),
					array('name'=>'Цитата (слева)','element'=>'p','attributes'=>array('class'=>'blockquote-left')),
					array('name'=>'Цитата (справа)','element'=>'p','attributes'=>array('class'=>'blockquote-right')),
					array('name'=>'Первая (маленькая)','element'=>'p','attributes'=>array('class'=>'first-normal')),
					array('name'=>'Первая (большая)','element'=>'p','attributes'=>array('class'=>'first-bold')),
					array('name'=>'Цитата (источник)','element'=>'span','attributes'=>array('class'=>'cite')),*/
					array('name'=>'Big','element'=>'big'),
					array('name'=>'Small','element'=>'small'),
					array('name'=>'Typewriter','element'=>'tt'),
					array('name'=>'Code','element'=>'code'),
					array('name'=>'Quotation','element'=>'q'),
				);
				break;
			}
			case 'editor':
			{
				// панель кнопок
				$options['toolbar']=array(
					array('name'=>'basicstyles','items'=>array('Bold','Italic','Underline','Strike','-','RemoveFormat')),
					array('name'=>'paragraph','items'=>array('NumberedList','BulletedList')),
					array('name'=>'links','items'=>array('Link','Unlink')),
					array('name'=>'justify','items'=>array('JustifyLeft','JustifyCenter','JustifyRight')),
					array('name'=>'insert','items'=>array('Image','Table','HorizontalRule','SpecialChar')),
					array('name'=>'clipboard','items'=>array('Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo')),
				);
				// css отображение
				$options['contentsCss'] = '/css/ckeditor/editor.css';
				// папка для загруски изображений
				if ($this->ufolder == '')
				{
					if (!Yii::app()->user->isGuest && Yii::app()->user->username!='')
					{
						$path = Yii::getPathOfAlias('webroot.users').DIRECTORY_SEPARATOR.Yii::app()->user->username.DIRECTORY_SEPARATOR;
						if (file_exists($path))
						{
							$_SESSION['KCFINDER']['disabled'] = false;
							$_SESSION['KCFINDER']['uploadURL'] = Yii::app()->baseUrl."/users/".Yii::app()->user->username."/";
							$_SESSION['KCFINDER']['uploadDir'] = $_SERVER['DOCUMENT_ROOT']."/users/".Yii::app()->user->username."/";
						}
						else
							$_SESSION['KCFINDER']['disabled'] = true;
					}
					else
						$_SESSION['KCFINDER']['disabled'] = true;
				}
				else
				{
					$path = Yii::getPathOfAlias('webroot.users').DIRECTORY_SEPARATOR.$this->ufolder.DIRECTORY_SEPARATOR;
					if (file_exists($path))
					{
						$_SESSION['KCFINDER']['disabled'] = false;
						$_SESSION['KCFINDER']['uploadURL'] = Yii::app()->baseUrl."/users/".$this->ufolder."/";
						$_SESSION['KCFINDER']['uploadDir'] = $_SERVER['DOCUMENT_ROOT']."/users/".$this->ufolder."/";
					}
					else
						$_SESSION['KCFINDER']['disabled'] = true;
				}
				// опции для файлменеджера
				$baseDir = Yii::app()->baseUrl.'/protected/extensions/ckeditor';
				$options['filebrowserBrowseUrl'] = $baseDir."/kcfinder/browse.php?type=files";
				$options['filebrowserImageBrowseUrl'] = $baseDir."/kcfinder/browse.php?type=images";
				$options['filebrowserFlashBrowseUrl'] = $baseDir."/kcfinder/browse.php?type=flash";
				$options['filebrowserUploadUrl'] = $baseDir."/kcfinder/upload.php?type=files";
				$options['filebrowserImageUploadUrl'] = $baseDir."/kcfinder/upload.php?type=images";
				$options['filebrowserFlashUploadUrl'] = $baseDir."/kcfinder/upload.php?type=flash";
				break;
			}
			case 'comments':
			{
				// панель кнопок
				$options['toolbar']=array(
					array('name'=>'basicstyles','items'=>array('Bold','Italic','Underline','Strike','-','RemoveFormat')),
					array('name'=>'links','items'=>array('Link','Unlink')),
				);
				// css отображение
				$options['contentsCss'] = '/css/ckeditor/comments.css';
				// папка для загруски изображений
				$_SESSION['KCFINDER']['disabled'] = true;
				// дополнительные опции
				$options['toolbarLocation'] = 'bottom';
				$options['resize_enabled'] = false;
				$options['removePlugins'] = 'elementspath';
				break;
			}
			default:
				$options['toolbar'] = $this->toolbar;
		}

		$fontFamilies='';
		foreach($this->fontFamilies as $k=>$v)
		{
			$fontFamilies.=$k.'/'.$v.';';
		}
		$options['font_names']=$fontFamilies;

		$fontSizes='';
		foreach($this->fontSizes as $k=>$v)
		{
			$fontSizes.=$k.'/'.$v.';';
		}
		$options['fontSize_sizes'] = $fontSizes;

		$options['extraPlugins'] = implode(',', $this->plugins);
		$options['skin'] = $this->skin;
		$options['theme'] = $this->theme;
		$options['height'] = $this->height;
		$options['width'] = $this->width;
		$options['removeButtons'] = 'About';

		// "склеиваем" опции
		if (is_array($this->options))
		{
			$options = array_merge($options, $this->options);
		}

		return CJavaScript::encode($options);
	}

	public function run(){
		parent::run();

		list($name, $id) = $this->resolveNameID();

		$baseDir = dirname(__FILE__);
		$assets = Yii::app()->getAssetManager()->publish($baseDir.DIRECTORY_SEPARATOR.'assets');

		$options = $this->makeOptions();
		$cs = Yii::app()->getClientScript();
		$cs->registerScriptFile($assets.'/ckeditor.js');
		$this->htmlOptions['id'] = $id;

		if (!array_key_exists('style', $this->htmlOptions))
		{
			$this->htmlOptions['style'] = "width:{$this->width};height:{$this->height};";
		}
		if (!array_key_exists('cols', $this->htmlOptions))
		{
			$this->htmlOptions['cols'] = self::COLS;
		}
		if (!array_key_exists('rows', $this->htmlOptions))
		{
			$this->htmlOptions['rows'] = self::ROWS;
		}

		$js =<<<EOP
CKEDITOR.replace('{$name}',{$options});
EOP;
		$cs->registerScript('Yii.'.get_class($this).'#'.$id, $js, CClientScript::POS_LOAD);

		if ($this->hasModel())
		{
			$html = CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
		}
		else
		{
			$html = CHtml::textArea($name, $this->value, $this->htmlOptions);
		}

		echo $html;

		$js_conf =<<<EOP
if(typeof CKEDITOR !== 'undefined') {

	CKEDITOR.on( 'instanceReady', function( ev ) {
		// Output paragraphs as <p>Text</p>.
		ev.editor.dataProcessor.writer.setRules( '*', {
			indent: false,
			breakBeforeOpen: true,
			breakAfterOpen: false,
			breakBeforeClose: false,
			breakAfterClose: true
		});
	});
}
EOP;
		$cs->registerScript('body', $js_conf, CClientScript::POS_LOAD);
	}
}
?>