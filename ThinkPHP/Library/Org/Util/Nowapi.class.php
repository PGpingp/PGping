<?php
/*
 * nowapi php语言sdk主类
 * 2014/11/12 Last Review by jason
 * --------------------------------------------------------------------------------------
 * 官网: http://www.k780.com
 * 文档: http://www.k780.com/api
 * 技术/反馈/讨论/支持: http://www.k780.com/intro/about.html
 * --------------------------------------------------------------------------------------
 * 使用方法:
 * 修改配置部分,相关值获取请登录官网 http://www.k780.com 用户中心查看，建议注册私有appkey。
 * --------------------------------------------------------------------------------------
 * 错误处理:
 * 当nowapi::callapi返回值为 false 时，可调用 nowapi::error() 查看。
 * --------------------------------------------------------------------------------------
 */
namespace Org\Util;
class Nowapi{
    //配置  需修改API_APPKEY及API_SECRET，获取您自己的APPKEY及SECRET需去官网注册并免费开通相应接口
    const API_URL='http://api.k780.com:88';
    const API_APPKEY='14660';
    const API_SECRET='69eee6a181435a160c82fab494b8fe5f';

    //错误容器
    private static $nowapi_error='';

    /*
     * API请求主函数
     * @a_parm
     *   $a_parm=array(
            'app'=>'接口代号',
            'format'=>'数据格式 json/base64',
            'c_timeout'=>'连接API超时时间',
        )
     * @return 错误:false 成功:结果集数组
     */
    public static function callapi($a_parm){
        //判断
        if(empty($a_parm['app'])){
            self::$nowapi_error='Parameter reqno nust be present';
            return false;
        }
        if(!empty($a_parm['format']) && !in_array($a_parm['format'],array('json','base64'))){
            self::$nowapi_error='Parameter format error';
            return false;
        }
        //参数组合$a_post
        foreach($a_parm as $key=>$val){
            $a_post[$key]=$val;
        }
        unset($a_parm);
        //预处理
        if(empty($a_post['appkey'])){
            $a_post['appkey']=self::API_APPKEY;
        }
        if(empty($a_post['secret'])){
            $a_post['secret']=self::API_SECRET;
        }
        if(empty($a_post['format'])){
            $a_post['format']='base64';
        }
        $a_post['sign']=md5(md5($a_post['appkey']).$a_post['secret']);
        $c_timeout=!empty($a_post['c_timeout'])?$a_post['c_timeout']:60;
        unset($a_post['c_timeout']);
        unset($a_post['secret']);

        //CURL
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,self::API_URL."/index.php");
        curl_setopt($curl,CURLOPT_POST,1);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$a_post);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl,CURLOPT_HEADER,0);
        curl_setopt($curl,CURLOPT_TIMEOUT,$c_timeout);
        if(!$result=curl_exec($curl)){
            self::$nowapi_error=curl_error($curl);
            curl_close($curl);
            return false;
        }
        curl_close($curl);
        //结果集处理
        if($a_post['format']=='base64'){
            $a_api=unserialize(base64_decode($result));
        }else{
            if(!$a_api=json_decode($result,true)){
                self::$nowapi_error='remote api not json decode';
                return false;
            }
        }
        if($a_api['success']!='1'){
            self::$nowapi_error=$a_api['msg'];
            return false;
        }
        return $a_api['result'];
    }

    /*捕捉错误*/
    public static function error(){
        if(empty(self::$nowapi_error)){
            return true;
        }
        return self::$nowapi_error;
    }
}
?>
