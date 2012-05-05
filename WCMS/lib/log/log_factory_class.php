<?php
/**
 * @copyright Copyright(c) 2010 jooyea.net
 * @file log_factory_class.php
 * @brief 日志接口文件
 * @author webning
 * @date 2010-12-09
 * @version 0.6
 */

/**
 * @brief ILogFactory 日志工厂类，负责生成日志对象，由配制文件负责日志的存储设备
 * @class ILogFactory
 */
class ILogFactory
{
    private static $log;
    private function __construct(){}
    private function __clone(){}
    /**
     * @brief 生成日志处理对象，包换各种介质的日志处理对象
     * @return Ilog
     */
    public function getInstance()
    {
        if(!self::$log instanceof self)
        {
            if(isset(IWeb::$app->config['logs'])) $logs = IWeb::$app->config['logs'];
            else
            {
                $logs['type'] = 'file';
                $logs['path'] = 'logs';
            }
            if($logs['type']=='file')
            {
                self::$log = new IFileLog($logs['path']);
            }
            else
            {
                self::$log = new IDBLog();
            }
        }
        return self::$log;
    }
}
?>