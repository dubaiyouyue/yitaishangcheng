// JavaScript Document

    var doc=document;
    var _wheelData=-1;
    var mainBox=doc.getElementById('mainBox');
    function bind(obj,type,handler){
    var node=typeof obj=="string"?$(obj):obj;
    if(node.addEventListener){
    node.addEventListener(type,handler,false);
    }else if(node.attachEvent){
    node.attachEvent('on'+type,handler);
    }else{
    node['on'+type]=handler;
    }
    }
    function mouseWheel(obj,handler){
    var node=typeof obj=="string"?$(obj):obj;
    bind(node,'mousewheel',function(event){
    var data=-getWheelData(event);
    handler(data);
    if(document.all){
    window.event.returnValue=false;
    }else{
    event.preventDefault();
    }
    });
    //火狐
    bind(node,'DOMMouseScroll',function(event){
    var data=getWheelData(event);
    handler(data);
    event.preventDefault();
    });
    function getWheelData(event){
    var e=event||window.event;
    return e.wheelDelta?e.wheelDelta:e.detail*40;
    }
    }
    function addScroll(){
    this.init.apply(this,arguments);
    }
    addScroll.prototype={
    init:function(mainBoxx,contentBoxx,className){
    var mainBoxx=doc.getElementById(mainBoxx);
    var contentBoxx=doc.getElementById(contentBoxx);
    var scrollDiv=this._createScroll(mainBoxx,className);
    this._resizeScorll(scrollDiv,mainBoxx,contentBoxx);
    this._tragScroll(scrollDiv,mainBoxx,contentBoxx);
    this._wheelChange(scrollDiv,mainBoxx,contentBoxx);
    this._clickScroll(scrollDiv,mainBoxx,contentBoxx);
    },
    //创建滚动条
    _createScroll:function(mainBoxx,className){
    var _scrollBox=doc.createElement('div')
    var _scroll=doc.createElement('div');
    var span=doc.createElement('span');
    _scrollBox.appendChild(_scroll);
    _scroll.appendChild(span);
    _scroll.className=className;
    mainBoxx.appendChild(_scrollBox);
    return _scroll;
    },
    //调整滚动条
    _resizeScorll:function(elementt,mainBoxx,contentBoxx){
    var p=elementt.parentNode;
    var conHeight=contentBoxx.offsetHeight;
    var _width=contentBoxx.clientWidth;
    var _height=contentBoxx.clientHeight;
    var _scrollWidth=elementt.offsetWidth;
    var _left=_width-_scrollWidth;
    p.style.width="12px";
    p.style.height=mainBoxx.clientHeight+"px";
    p.style.left=_left+"px";
    p.style.position="absolute";
    p.style.background="#ccc";
    contentBoxx.style.width=(mainBoxx.offsetWidth-_scrollWidth)+"px";
    var _scrollHeight=parseInt(_height*(_height/conHeight));
    if(_scrollHeight>=mainBoxx.clientHeight){
    elementt.parentNode.style.display="none";
    }
    elementt.style.height=_scrollHeight+"px";
    },
    //拖动滚动条
    _tragScroll:function(elementt,mainBoxx,contentBoxx){
    var mainHeight=mainBoxx.clientHeight;
    elementt.onmousedown=function(event){
    var _this=this;
    var _scrollTop=elementt.offsetTop;
    var e=event||window.event;
    var top=e.clientY;
    //this.onmousemove=scrollGo;
    document.onmousemove=scrollGo;
    document.onmouseup=function(event){
    this.onmousemove=null;
    }
    function scrollGo(event){
    var e=event||window.event;
    var _top=e.clientY;
    var _t=_top-top+_scrollTop;
    if(_t>(mainHeight-elementt.offsetHeight)){
    _t=mainHeight-elementt.offsetHeight;
    }
    if(_t<=0){
    _t=0;
    }
    elementt.style.top=_t+"px";
    contentBoxx.style.top=-_t*(contentBoxx.offsetHeight/mainBoxx.offsetHeight)+"px";
    _wheelData=_t;
    }
    }
    elementt.onmouseover=function(){
    //this.style.background="#ccc";
    }
    elementt.onmouseout=function(){
    //this.style.background="#999";
    }
    },
    //鼠标滚轮滚动，滚动条滚动
    _wheelChange:function(elementt,mainBoxx,contentBoxx){
    var node=typeof mainBoxx=="string"?$(mainBoxx):mainBoxx;
    var flag=0,rate=0,wheelFlag=0;
    if(node){
    mouseWheel(node,function(data){
    wheelFlag+=data;
    if(_wheelData>=0){
    flag=_wheelData;
    elementt.style.top=flag+"px";
    wheelFlag=_wheelData*12;
    _wheelData=-1;
    }else{
    flag=wheelFlag/12;
    }
    if(flag<=0){
    flag=0;
    wheelFlag=0;
    }
    if(flag>=(mainBoxx.offsetHeight-elementt.offsetHeight)){
    flag=(mainBoxx.clientHeight-elementt.offsetHeight);
    wheelFlag=(mainBoxx.clientHeight-elementt.offsetHeight)*12;
    }
    elementt.style.top=flag+"px";
	
    contentBoxx.style.top=-flag*(contentBoxx.offsetHeight/mainBoxx.offsetHeight)+"px";
	//alert(mainBoxx.offsetHeight);
    });
    }
    },
    _clickScroll:function(elementt,mainBoxx,contentBoxx){
    var p=elementt.parentNode;
    p.onclick=function(event){
    var e=event||window.event;
    var t=e.target||e.srcelementt;
    var sTop=document.documentelementt.scrollTop>0?document.documentelementt.scrollTop:document.body.scrollTop;
    var top=mainBoxx.offsetTop;
    var _top=e.clientY+sTop-top-elementt.offsetHeight/2;
    if(_top<=0){
    _top=0;
    }
    if(_top>=(mainBoxx.clientHeight-elementt.offsetHeight)){
    _top=mainBoxx.clientHeight-elementt.offsetHeight;
    }
    if(t!=elementt){
    elementt.style.top=_top+"px";
    contentBoxx.style.top=-_top*(contentBoxx.offsetHeight/mainBoxx.offsetHeight)+"px";
    _wheelData=_top;
    }
    }
    }
    }
    
