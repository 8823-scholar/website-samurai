<?php
/**
 * コンポーネント - パッケージ
 *
 * パッケージ関連のデータ操作を目的としたコンポーネント
 * 
 * @package    SamuraiWEB
 * @subpackage Package
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 */
class Web_Package_Manager extends Samurai_Model
{
    /**
     * テーブル名(package)
     *
     * @access   protected
     * @var      string
     */
    protected $_table = 'package';

    /**
     * テーブル名(releases)
     *
     * @access   protected
     * @var      string
     */
    protected $_table_releases = 'package_releases';

    /**
     * テーブル名(releases_files)
     *
     * @access   protected
     * @var      string
     */
    protected $_table_releases_files = 'package_releases_files';

    /**
     * テーブル名(mainteners)
     *
     * @access   protected
     * @var      string
     */
    protected $_table_mainteners = 'package_mainteners';


    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct()
    {
        
    }


    /**
     * 取得
     *
     * @access     public
     * @param      mixed    $id
     * @return     object   ActiveGatewayRecord
     */
    public function get($id)
    {
        if(is_object($id) && $id instanceof ActiveGatewayCondition){
            return $this->AG->findDetail($this->_table, $id);
        } else {
            return $this->AG->find($this->_table, $id);
        }
    }

    /**
     * aliasから取得
     *
     * @access     public
     * @param      string   $alias
     * @return     object   ActiveGatewayRecord
     */
    public function getByAlias($alias)
    {
        return $this->AG->findBy($this->_table, 'alias', $alias);
    }

    /**
     * 複数取得
     *
     * @access     public
     * @param      object   $condition   ActiveGatewayCondition
     * @return     object   ActiveGatewayRecords
     */
    public function gets($condition=NULL)
    {
        $this->_initAGCondition($condition);
        if(!$condition->order) $condition->order->id = 'ASC';
        return $this->AG->findAllDetail($this->_table, $condition);
    }

    /**
     * リリースの取得
     *
     * @access     public
     * @param      int      $package_id
     * @param      mixed    $id
     * @return     object   ActiveGatewayRecord
     */
    public function getRelease($package_id, $id)
    {
        if(is_object($id) && $id instanceof ActiveGatewayCondition){
            $condition = $id;
        } else {
            $this->_initAGCondition($condition);
            $condition->where->id = $id;
        }
        $condition->where->package_id = $package_id;
        return $this->AG->findDetail($this->_table_releases, $condition);
    }

    /**
     * リリースの複数取得
     *
     * @access     public
     * @param      int      $package_id
     * @param      object   $condition   ActiveGatewayCondition
     * @return     object   ActiveGatewayRecords
     */
    public function getReleases($package_id, $condition=NULL)
    {
        $this->_initAGCondition($condition);
        $condition->where->package_id = $package_id;
        if(!$condition->order) $condition->order->datetime = 'DESC';
        return $this->AG->findAllDetail($this->_table_releases, $condition);
    }

    /**
     * リリースファイルの取得
     *
     * @access     public
     * @param      int      $package_id
     * @param      int      $release_id
     * @param      mixed    $id
     * @return     object   ActiveGatewayRecord
     */
    public function getReleaseFile($package_id, $release_id, $id)
    {
        if(is_object($id) && $id instanceof ActiveGatewayCondition){
            $condition = $id;
        } else {
            $this->_initAGCondition($condition);
            $condition->where->id = $id;
        }
        $condition->where->package_id = $package_id;
        $condition->where->release_id = $release_id;
        return $this->AG->findDetail($this->_table_releases_files, $condition);
    }

    /**
     * リリースファイルの複数取得
     *
     * @access     public
     * @param      int      $package_id
     * @param      int      $release_id
     * @param      object   $condition   ActiveGatewayCondition
     * @return     object   ActiveGatewayRecords
     */
    public function getReleaseFiles($package_id, $release_id, $condition=NULL)
    {
        $this->_initAGCondition($condition);
        $condition->where->package_id = $package_id;
        $condition->where->release_id = $release_id;
        if(!$condition->order) $condition->order->sort = 'ASC';
        return $this->AG->findAllDetail($this->_table_releases_files, $condition);
    }

    /**
     * メンテナーの取得
     *
     * @access     public
     * @param      int      $package_id
     * @param      mixed    $id
     * @return     object   ActiveGatewayRecord
     */
    public function getMaintener($package_id, $id)
    {
        if(is_object($id) && $id instanceof ActiveGatewayCondition){
            $condition = $id;
        } else {
            $this->_initAGCondition($condition);
            $condition->where->id = $id;
        }
        $condition->where->package_id = $package_id;
        return $this->AG->findDetail($this->_table_mainteners, $condition);
    }

    /**
     * メンテナーの複数取得
     *
     * @access     public
     * @param      int      $package_id
     * @param      object   $condition   ActiveGatewayCondition
     * @return     object   ActiveGatewayRecords
     */
    public function getMainteners($package_id, $condition=NULL)
    {
        $this->_initAGCondition($condition);
        $condition->where->package_id = $package_id;
        if(!$condition->order) $condition->order->role = 'ASC';
        return $this->AG->findAllDetail($this->_table_mainteners, $condition);
    }





    /**
     * 作成
     *
     * @access     public
     * @param      mixed    $dto
     * @return     object   ActiveGatewayRecord
     */
    public function add($dto)
    {
        $dto = (object)$dto;
        return $this->AG->create($this->_table, $dto);
    }

    /**
     * リリースの追加
     *
     * @access     public
     * @param      int      $package_id
     * @param      mixed    $dto
     * @return     object   ActiveGatewayRecord
     */
    public function addRelease($package_id, $dto)
    {
        $dto = (object)$dto;
        $dto->package_id = $package_id;
        $release = $this->AG->create($this->_table_releases, $dto);
        return $release;
    }

    /**
     * リリースファイルの追加
     *
     * @access     public
     * @param      int      $package_id
     * @param      int      $release_id
     * @param      mixed    $dto
     * @return     object   ActiveGatewayRecord
     */
    public function addReleaseiFile($package_id, $release_id, $dto)
    {
        $dto = (object)$dto;
        $dto->package_id = $package_id;
        $dto->release_id = $release_id;
        $file = $this->AG->create($this->_table_releases_files, $dto);
        return $file;
    }

    /**
     * メンテナーの追加
     *
     * @access     public
     * @param      int      $package_id
     * @param      mixed    $dto
     * @return     object   ActiveGatewayRecord
     */
    public function addMaintener($package_id, $dto)
    {
        $dto = (object)$dto;
        $dto->package_id = $package_id;
        return $this->AG->create($this->_table_mainteners, $dto);
    }



    /**
     * 保存
     *
     * @access     public
     * @param      object   $package      ActiveGatewayRecord
     * @param      mixed    $attributes   上書き値
     */
    public function save($package, $attributes=array())
    {
        foreach($attributes as $_key => $_val) $package->$_key = $_val;
        $this->AG->save($package);
    }

    /**
     * リリースの保存
     *
     * @access     public
     * @param      object   $release      ActiveGatewayRecord
     * @param      mixed    $attributes   上書き値
     */
    public function saveRelease($release, $attributes=array())
    {
        foreach($attributes as $_key => $_val) $release->$_key = $_val;
        $this->AG->save($release);
    }

    /**
     * リリースファイルの保存
     *
     * @access     public
     * @param      object   $file         ActiveGatewayRecord
     * @param      mixed    $attributes   上書き値
     */
    public function saveReleaseFile($file, $attributes=array())
    {
        foreach($attributes as $_key => $_val) $file->$_key = $_val;
        $this->AG->save($file);
    }

    /**
     * メンテナーの保存
     *
     * @access     public
     * @param      object   $maintener    ActiveGatewayRecord
     * @param      mixed    $attributes   上書き値
     */
    public function saveMaintener($maintener, $attributes=array())
    {
        foreach($attributes as $_key => $_val) $maintener->$_key = $_val;
        $this->AG->save($maintener);
    }



    /**
     * 編集
     *
     * @access     public
     * @param      mixed    $id
     * @param      mixed    $attributes
     */
    public function edit($id, $attributes=array())
    {
        if(is_object($id) && $id instanceof ActiveGatewayCondition){
            $this->AG->updateDetail($this->_table, $id, $attributes);
        } else {
            $this->AG->update($this->_table, $id, $attributes);
        }
    }

    /**
     * リリースの編集
     *
     * @access     public
     * @param      int      $package_id
     * @param      mixed    $id
     * @param      mixed    $attributes
     */
    public function editRelease($package_id, $id, $attributes=array())
    {
        if(is_object($id) && $id instanceof ActiveGatewayCondition){
            $condition = $id;
        } else {
            $this->_initAGCondition($condition);
            $condition->where->id = $id;
        }
        $condition->where->package_id = $package_id;
        $this->AG->updateDetail($this->_table_releases, $condition, $attributes);
    }

    /**
     * リリースファイルの編集
     *
     * @access     public
     * @param      int      $package_id
     * @param      int      $release_id
     * @param      mixed    $id
     * @param      mixed    $attributes
     */
    public function editReleaseFile($package_id, $release_id, $id, $attributes=array())
    {
        if(is_object($id) && $id instanceof ActiveGatewayCondition){
            $condition = $id;
        } else {
            $this->_initAGCondition($condition);
            $condition->where->id = $id;
        }
        $condition->where->package_id = $package_id;
        $condition->where->release_id = $release_id;
        $this->AG->updateDetail($this->_table_releases_files, $condition, $attributes);
    }

    /**
     * メンテナーの編集
     *
     * @access     public
     * @param      int      $package_id
     * @param      mixed    $id
     * @param      mixed    $attributes
     */
    public function editMaintener($package_id, $id, $attributes=array())
    {
        if(is_object($id) && $id instanceof ActiveGatewayCondition){
            $condition = $id;
        } else {
            $this->_initAGCondition($condition);
            $condition->where->id = $id;
        }
        $condition->where->package_id = $package_id;
        $this->AG->updateDetail($this->_table_mainteners, $condition, $attributes);
    }



    /**
     * 破壊
     *
     * @access     public
     * @param      object   $package
     */
    public function destroy($package)
    {
        $this->AG->destroy($package);
    }

    /**
     * リリースの破壊
     *
     * @access     public
     * @param      object   $release
     */
    public function destroyRelease($release)
    {
        $this->AG->destroy($release);
    }

    /**
     * リリースファイルの破壊
     *
     * @access     public
     * @param      object   $file
     */
    public function destroyReleaseFile($file)
    {
        $this->AG->destroy($file);
    }

    /**
     * メンテナーの破壊
     *
     * @access     public
     * @param      object   $maintener
     */
    public function destroyMaintener($maintener)
    {
        $this->AG->destroy($maintener);
    }



    /**
     * 削除
     *
     * @access     public
     * @param      mixed    $id
     */
    public function delete($id)
    {
        if(is_object($id) && $id instanceof ActiveGatewayCondition){
            $condition = $id;
        } else {
            $this->_initAGCondition($condition);
            $condition->where->id = $id;
        }
        $this->AG->deleteDetail($this->_table, $condition);
    }

    /**
     * リリースの削除
     *
     * @access     public
     * @param      int      $package_id
     * @param      mixed    $id
     */
    public function deleteRelease($package_id, $id)
    {
        if(is_object($id) && $id instanceof ActiveGatewayCondition){
            $condition = $id;
        } else {
            $this->_initAGCondition($condition);
            $condition->where->id = $id;
        }
        $condition->where->package_id = $package_id;
        $this->AG->deleteDetail($this->_table_releases, $condition);
    }

    /**
     * リリースファイルの削除
     *
     * @access     public
     * @param      int      $package_id
     * @param      int      $release_id
     * @param      mixed    $id
     */
    public function deleteReleaseFile($package_id, $release_id, $id)
    {
        if(is_object($id) && $id instanceof ActiveGatewayCondition){
            $condition = $id;
        } else {
            $this->_initAGCondition($condition);
            $condition->where->id = $id;
        }
        $condition->where->package_id = $package_id;
        $condition->where->release_id = $release_id;
        $this->AG->deleteDetail($this->_table_releases_files, $condition);
    }

    /**
     * メンテナーの削除
     *
     * @access     public
     * @param      int      $package_id
     * @param      mixed    $id
     */
    public function deleteMaintener($package_id, $id)
    {
        if(is_object($id) && $id instanceof ActiveGatewayCondition){
            $condition = $id;
        } else {
            $this->_initAGCondition($condition);
            $condition->where->id = $id;
        }
        $condition->where->package_id = $package_id;
        $this->AG->deleteDetail($this->_table_mainteners, $condition);
    }





    /**
     * ダウンロードされた
     *
     * @access    public
     * @param     object   $file   ActiveGatewayRecord
     */
    public function downloaded(ActiveGatewayRecord $file)
    {
        $sql = "UPDATE " . $this->_table_releases_files . "
                SET downloaded_count = downloaded_count + 1, updated_at = :time
                WHERE id = :id AND package_id = :package_id AND release_id = :release_id";
        $params = array(':time' => time(), ':id' => $file->id, ':package_id' => $file->package_id, ':release_id' => $file->release_id);
        $this->AG->executeUpdate($sql, $params);
        
        $sql = "UPDATE " . $this->_table_releases . "
                SET downloaded_count = downloaded_count + 1, updated_at = :time
                WHERE id = :id AND package_id = :package_id";
        $params = array(':time' => time(), ':id' => $file->release_id, ':package_id' => $file->package_id);
        $this->AG->executeUpdate($sql, $params);

        $sql = "UPDATE " . $this->_table . "
                SET downloaded_count = downloaded_count + 1, updated_at = :time
                WHERE id = :id";
        $params = array(':time' => time(), ':id' => $file->package_id);
        $this->AG->executeUpdate($sql, $params);
    }
}
