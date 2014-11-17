(function(window,doc,undef){var docElement=doc.documentElement,sTimeout=window.setTimeout,firstScript=doc.getElementsByTagName("script")[0],toString={}.toString,execStack=[],started=0,noop=function(){},isGecko=("MozAppearance"in docElement.style),isGeckoLTE18=isGecko&&!!doc.createRange().compareNode,insBeforeObj=isGeckoLTE18?docElement:firstScript.parentNode,isOpera=window.opera&&toString.call(window.opera)=="[object Opera]",isIE=!!doc.attachEvent&&!isOpera,isOlderWebkit=('webkitAppearance'in docElement.style)&&!('async'in doc.createElement('script')),strJsElem=isGecko?"object":(isIE||isOlderWebkit)?"script":"img",strCssElem=isIE?"script":(isOlderWebkit)?"img":strJsElem,isArray=Array.isArray||function(obj){return toString.call(obj)=="[object Array]";},isObject=function(obj){return Object(obj)===obj;},isString=function(s){return typeof s=="string";},isFunction=function(fn){return toString.call(fn)=="[object Function]";},readFirstScript=function(){if(!firstScript||!firstScript.parentNode){firstScript=doc.getElementsByTagName("script")[0];}},globalFilters=[],scriptCache={},prefixes={timeout:function(resourceObj,prefix_parts){if(prefix_parts.length){resourceObj['timeout']=prefix_parts[0];}
return resourceObj;}},handler,yepnope;function isFileReady(readyState){return(!readyState||readyState=="loaded"||readyState=="complete"||readyState=="uninitialized");}
function injectJs(src,cb,attrs,timeout,err,internal){var script=doc.createElement("script"),done,i;timeout=timeout||yepnope['errorTimeout'];script.src=src;for(i in attrs){script.setAttribute(i,attrs[i]);}
cb=internal?executeStack:(cb||noop);script.onreadystatechange=script.onload=function(){if(!done&&isFileReady(script.readyState)){done=1;cb();script.onload=script.onreadystatechange=null;}};sTimeout(function(){if(!done){done=1;cb(1);}},timeout);readFirstScript();err?script.onload():firstScript.parentNode.insertBefore(script,firstScript);}
function injectCss(href,cb,attrs,timeout,err,internal){var link=doc.createElement("link"),done,i;timeout=timeout||yepnope['errorTimeout'];cb=internal?executeStack:(cb||noop);link.href=href;link.rel="stylesheet";link.type="text/css";for(i in attrs){link.setAttribute(i,attrs[i]);}
if(!err){readFirstScript();firstScript.parentNode.insertBefore(link,firstScript);sTimeout(cb,0);}}
function executeStack(){var i=execStack.shift();started=1;if(i){if(i['t']){sTimeout(function(){(i['t']=="c"?yepnope['injectCss']:yepnope['injectJs'])(i['s'],0,i['a'],i['x'],i['e'],1);},0);}
else{i();executeStack();}}
else{started=0;}}
function preloadFile(elem,url,type,splicePoint,dontExec,attrObj,timeout){timeout=timeout||yepnope['errorTimeout'];var preloadElem=doc.createElement(elem),done=0,firstFlag=0,stackObject={"t":type,"s":url,"e":dontExec,"a":attrObj,"x":timeout};if(scriptCache[url]===1){firstFlag=1;scriptCache[url]=[];}
function onload(first){if(!done&&isFileReady(preloadElem.readyState)){stackObject['r']=done=1;!started&&executeStack();if(first){if(elem!="img"){sTimeout(function(){insBeforeObj.removeChild(preloadElem)},50);}
for(var i in scriptCache[url]){if(scriptCache[url].hasOwnProperty(i)){scriptCache[url][i].onload();}}
preloadElem.onload=preloadElem.onreadystatechange=null;}}}
if(elem=="object"){preloadElem.data=url;preloadElem.setAttribute("type","text/css");}else{preloadElem.src=url;preloadElem.type=elem;}
preloadElem.width=preloadElem.height="0";preloadElem.onerror=preloadElem.onload=preloadElem.onreadystatechange=function(){onload.call(this,firstFlag);};execStack.splice(splicePoint,0,stackObject);if(elem!="img"){if(firstFlag||scriptCache[url]===2){readFirstScript();insBeforeObj.insertBefore(preloadElem,isGeckoLTE18?null:firstScript);sTimeout(onload,timeout);}
else{scriptCache[url].push(preloadElem);}}}
function load(resource,type,dontExec,attrObj,timeout){started=0;type=type||"j";if(isString(resource)){preloadFile(type=="c"?strCssElem:strJsElem,resource,type,this['i']++,dontExec,attrObj,timeout);}else{execStack.splice(this['i']++,0,resource);execStack.length==1&&executeStack();}
return this;}
function getYepnope(){var y=yepnope;y['loader']={"load":load,"i":0};return y;}
yepnope=function(needs){var i,need,chain=this['yepnope']['loader'];function satisfyPrefixes(url){var parts=url.split("!"),gLen=globalFilters.length,origUrl=parts.pop(),pLen=parts.length,res={"url":origUrl,"origUrl":origUrl,"prefixes":parts},mFunc,j,prefix_parts;for(j=0;j<pLen;j++){prefix_parts=parts[j].split('=');mFunc=prefixes[prefix_parts.shift()];if(mFunc){res=mFunc(res,prefix_parts);}}
for(j=0;j<gLen;j++){res=globalFilters[j](res);}
return res;}
function getExtension(url){var b=url.split('?')[0];return b.substr(b.lastIndexOf('.')+1);}
function loadScriptOrStyle(input,callback,chain,index,testResult){var resource=satisfyPrefixes(input),autoCallback=resource['autoCallback'],extension=getExtension(resource['url']);if(resource['bypass']){return;}
if(callback){callback=isFunction(callback)?callback:callback[input]||callback[index]||callback[(input.split("/").pop().split("?")[0])];}
if(resource['instead']){return resource['instead'](input,callback,chain,index,testResult);}
else{if(scriptCache[resource['url']]&&resource['reexecute']!==true){resource['noexec']=true;}
else{scriptCache[resource['url']]=1;}
input&&chain.load(resource['url'],((resource['forceCSS']||(!resource['forceJS']&&"css"==getExtension(resource['url']))))?"c":undef,resource['noexec'],resource['attrs'],resource['timeout']);if(isFunction(callback)||isFunction(autoCallback)){chain['load'](function(){getYepnope();callback&&callback(resource['origUrl'],testResult,index);autoCallback&&autoCallback(resource['origUrl'],testResult,index);scriptCache[resource['url']]=2;});}}}
function loadFromTestObject(testObject,chain){var testResult=!!testObject['test'],group=testResult?testObject['yep']:testObject['nope'],always=testObject['load']||testObject['both'],callback=testObject['callback']||noop,cbRef=callback,complete=testObject['complete']||noop,needGroupSize,callbackKey;function handleGroup(needGroup,moreToCome){if(''!==needGroup&&!needGroup){!moreToCome&&complete();}
else if(isString(needGroup)){if(!moreToCome){callback=function(){var args=[].slice.call(arguments);cbRef.apply(this,args);complete();};}
loadScriptOrStyle(needGroup,callback,chain,0,testResult);}
else if(isObject(needGroup)){needGroupSize=(function(){var count=0,i
for(i in needGroup){if(needGroup.hasOwnProperty(i)){count++;}}
return count;})();for(callbackKey in needGroup){if(needGroup.hasOwnProperty(callbackKey)){if(!moreToCome&&!(--needGroupSize)){if(!isFunction(callback)){callback[callbackKey]=(function(innerCb){return function(){var args=[].slice.call(arguments);innerCb&&innerCb.apply(this,args);complete();};})(cbRef[callbackKey]);}
else{callback=function(){var args=[].slice.call(arguments);cbRef.apply(this,args);complete();};}}
loadScriptOrStyle(needGroup[callbackKey],callback,chain,callbackKey,testResult);}}}}
handleGroup(group,!!always||!!testObject['complete']);always&&handleGroup(always);!always&&!!testObject['complete']&&handleGroup('');}
if(isString(needs)){loadScriptOrStyle(needs,0,chain,0);}
else if(isArray(needs)){for(i=0;i<needs.length;i++){need=needs[i];if(isString(need)){loadScriptOrStyle(need,0,chain,0);}
else if(isArray(need)){yepnope(need);}
else if(isObject(need)){loadFromTestObject(need,chain);}}}
else if(isObject(needs)){loadFromTestObject(needs,chain);}};yepnope['addPrefix']=function(prefix,callback){prefixes[prefix]=callback;};yepnope['addFilter']=function(filter){globalFilters.push(filter);};yepnope['errorTimeout']=1e4;if(doc.readyState==null&&doc.addEventListener){doc.readyState="loading";doc.addEventListener("DOMContentLoaded",handler=function(){doc.removeEventListener("DOMContentLoaded",handler,0);doc.readyState="complete";},0);}
window['yepnope']=getYepnope();window['yepnope']['executeStack']=executeStack;window['yepnope']['injectJs']=injectJs;window['yepnope']['injectCss']=injectCss;})(this,document);