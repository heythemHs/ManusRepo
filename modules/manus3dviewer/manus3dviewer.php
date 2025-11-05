<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class Manus3dviewer extends Module
{
    public function __construct()
    {
        $this->name = 'manus3dviewer';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Manus AI';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.7',
            'max' => _PS_VERSION_,
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Manus 3D Product Viewer');
        $this->description = $this->l('Displays an interactive 3D product viewer on the front page using <model-viewer>.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
    }

    public function install()
    {
        if (!parent::install() ||
            !$this->registerHook('displayHome') ||
            !$this->registerHook('header') ||
            !Configuration::updateValue('MANUS3DVIEWER_MODEL_URL', 'https://modelviewer.dev/shared-assets/models/Astronaut.glb')
        ) {
            return false;
        }

        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall() ||
            !Configuration::deleteByName('MANUS3DVIEWER_MODEL_URL')
        ) {
            return false;
        }

        return true;
    }

    public function getContent()
    {
        $output = '';

        if (Tools::isSubmit('submitManus3dviewerModule')) {
            $model_url = Tools::getValue('MANUS3DVIEWER_MODEL_URL');
            Configuration::updateValue('MANUS3DVIEWER_MODEL_URL', $model_url);
            $output .= $this->displayConfirmation($this->l('Settings updated.'));
        }

        return $output . $this->displayForm();
    }

    public function displayForm()
    {
        $form = [
            'form' => [
                'legend' => [
                    'title' => $this->l('Settings'),
                ],
                'input' => [
                    [
                        'type' => 'text',
                        'label' => $this->l('3D Model URL (GLB/GLTF)'),
                        'name' => 'MANUS3DVIEWER_MODEL_URL',
                        'desc' => $this->l('Enter the public URL for your 3D model file (e.g., .glb or .gltf).'),
                        'required' => true,
                    ],
                ],
                'submit' => [
                    'title' => $this->l('Save'),
                ],
            ],
        ];

        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->submit_action = 'submitManus3dviewerModule';
        $helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');

        $helper->fields_value['MANUS3DVIEWER_MODEL_URL'] = Configuration::get('MANUS3DVIEWER_MODEL_URL');

        return $helper->generateForm([$form]);
    }

    public function hookDisplayHome($params)
    {
        $this->context->smarty->assign([
            'manus3dviewer_model_url' => Configuration::get('MANUS3DVIEWER_MODEL_URL'),
        ]);

        return $this->display(__FILE__, 'displayHome.tpl');
    }

    public function hookHeader($params)
    {
        // Load the <model-viewer> library from CDN
        $this->context->controller->registerJavascript(
            'remote-model-viewer',
            'https://ajax.googleapis.com/ajax/libs/model-viewer/3.4.0/model-viewer.min.js',
            ['server' => 'remote', 'position' => 'bottom', 'priority' => 10]
        );

        // Load the module's custom CSS
        $this->context->controller->registerStylesheet(
            'module-' . $this->name . '-style',
            'modules/' . $this->name . '/views/css/manus3dviewer.css',
            ['media' => 'all', 'priority' => 150]
        );
    }
}
