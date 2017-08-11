<?php
/**
 * WaPoNe
 *
 * @category   WaPoNe
 * @package    WaPoNe_Stickers
 * @copyright  Copyright (c) 2017 WaPoNe (http://www.fantetti.net)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace WaPoNe\Stickers\Model\Config\Backend;

class Image extends \Magento\Config\Model\Config\Backend\Image
{

    /**
     * The tail part of directory path for uploading
     *
     */
    const UPLOAD_DIR = 'wapone/stickers/images'; // Folder save image

    /**
     * Return path to directory for upload file
     *
     * @return string
     * @throw \Magento\Framework\Exception\LocalizedException
     */
    protected function _getUploadDir()
    {

        return $this->_mediaDirectory->getAbsolutePath($this->_appendScopeInfo(self::UPLOAD_DIR));
    }

    /**
     * Makes a decision about whether to add info about the scope.
     *
     * @return boolean
     */
    protected function _addWhetherScopeInfo()
    {
        return true;
    }

    /**
     * Getter for allowed extensions of uploaded files.
     *
     * @return string[]
     */
    protected function _getAllowedExtensions()
    {
        return ['jpg', 'jpeg', 'gif', 'png', 'svg'];
    }

    /**
     * Save uploaded file before saving config value
     *
     * Save changes and delete file if "delete" option passed
     *
     * @return $this
     */
    public function beforeSave()
    {

        $file = $this->getFileData();
        $value = $this->getValue();

        $deleteFlag = is_array($value) && !empty($value['delete']);
        $fileTmpName = isset($file["tmp_name"]);

        if ($this->getOldValue() && ($fileTmpName || $deleteFlag)) {
            $this->_mediaDirectory->delete(self::UPLOAD_DIR . '/' . $this->getOldValue());
        }
        return parent::beforeSave();
    }

}
