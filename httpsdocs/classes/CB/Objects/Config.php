<?php
namespace CB\Objects;

use CB\DataModel as DM;
use CB\Objects;

class Config extends Object
{

    /**
     * internal function used by create method for creating custom data
     * @return void
     */
    protected function createCustomData()
    {
        parent::createCustomData();

        $d = &$this->data;
        $dd = &$d['data'];

        $p = array(
            'pid' => empty($d['pid'])
                ? null
                : $this->getDMPid($d['pid'])
            ,'param' => $dd['_title']
            ,'value' => $dd['value']
        );

        DM\Config::create($p);
    }

    /**
     * update objects custom data
     * @return void
     */
    protected function updateCustomData()
    {
        parent::updateCustomData();

        $od = $this->oldObject->getData();
        // var_export($od);
        $id = DM\Config::toId($od['data']['_title'], 'param');
        // var_export($id);
        $d = &$this->data;
        $dd = &$d['data'];

        $p = array(
            'id' => $id
            ,'pid' => empty($d['pid'])
                ? null
                : $this->getDMPid($d['pid'])
            ,'param' => $dd['_title']
            ,'value' => $dd['value']
        );

        DM\Config::update($p);
    }

    public function delete($permanent = false)
    {
        //always delete config elements permanently
        parent::delete(true);
    }

    protected function deleteCustomData($permanent)
    {
        if ($permanent) {
            $d = &$this->data['data'];

            DM\Config::delete(DM\Config::toId($d['_title'], 'param'));
        }

        parent::deleteCustomData($permanent);
    }

    /**
     * get data model pid that is different from tree one
     * @param  [type] $pid [description]
     * @return [type] [description]
     */
    protected function getDMPid($pid)
    {
        $name = Objects::getName($pid);
        $rez = DM\Config::toId($name, 'param');

        return $rez;
    }
}