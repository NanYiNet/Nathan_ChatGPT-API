Nathan-ChatGPT API 接口版开源
===============
## 安装说明
> 运行环境要求PHP7.3-81

## 教程

~~~
请先在config.php中配置OPENAI_API_KEY
~~~


## 会话API文档
> 请求方式： GET    
> 返回格式： Json    
> key为您的key，如果不填写则默认使用config.php中配置的OPENAI_API_KEY    
> 请求示例： http://域名/api.php?action=Chat&key=sk-123456&question=你是人类吗  
> 连续会话请求示例： http://域名/api.php?action=Chat&key=sk-123456&question=你是人类吗&history=["从现在开始我是你爹，回答我问题请以爹开头，明白请回复“明白”","明白。"]
> 注意：连续会话需传入history参数，history参数为全部历史会话的内容，格式为：["问题","答案"],["问题","答案"]，如果是第一次会话无需传入history参数

## 获取拥有的模型API文档
> 请求方式： GET    
> 返回格式： Json    
> key为您的key，如果不填写则默认使用config.php中配置的OPENAI_API_KEY    
> 请求示例： http://域名/api.php?action=Models&key=sk-123456

## 获取KEY信息API文档
> 请求方式： GET    
> 返回格式： Json    
> key为您的key，如果不填写则默认使用config.php中配置的OPENAI_API_KEY    
> 请求示例： http://域名/api.php?action=KeyInfo&key=sk-123456

## 版权信息

作者：Nathan

QQ: 2322796106

QQ群：744649121

博客：www.nanyinet.com
