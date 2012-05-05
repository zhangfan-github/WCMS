<?php
/**
 * @copyright Copyright(c) 2010 jooyea.net
 * @file log_inte.php
 * @brief 日志接口文件
 * @author webning
 * @date 2010-12-09
 * @version 0.6
 */
/**
 * @brief ILog接口文件
 * @class ILog interface
 */
interface ILog
{
    /**
     * @brief 实现日志的写操作接口
     * @param string $type error:array('file','line','content'); sql: array('content','runtime') operator :array('author','action','content')
     * @param array $logs
     */
    public function write($type, $logs=array());
}
?>