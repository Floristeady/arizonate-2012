
<head>
	

<style>
ul.topnav {  
    list-style: none;  
    padding: 0 20px;  
    margin: 0;  
    float: left;  
    width: 920px;  
    background: #222;  
    font-size: 1.2em;  
    background: url(topnav_bg.gif) repeat-x;  
}  
ul.topnav li {  
    float: left;  
    margin: 0;  
    padding: 0 15px 0 0;  
    position: relative; /*--Declare X and Y axis base for sub navigation--*/  
}  
ul.topnav li a{  
    padding: 10px 5px;  
    color: #fff;  
    display: block;  
    text-decoration: none;  
    float: left;  
}  
ul.topnav li a:hover{  
    background: url(topnav_hover.gif) no-repeat center top;  
}  
ul.topnav li span { /*--Drop down trigger styles--*/  
    width: 17px;  
    height: 35px;  
    float: left;  
    background: url(subnav_btn.gif) no-repeat center top;  
}  
ul.topnav li span.subhover {background-position: center bottombottom; cursor: pointer;} /*--Hover effect for trigger--*/  
ul.topnav li ul.subnav {  
    list-style: none;  
    position: absolute; /*--Important - Keeps subnav from affecting main navigation flow--*/  
    left: 0; top: 35px;  
    background: #333;  
    margin: 0; padding: 0;  
    display: none;  
    float: left;  
    width: 170px;  
    border: 1px solid #111;  
}  
ul.topnav li ul.subnav li{  
    margin: 0; padding: 0;  
    border-top: 1px solid #252525; /*--Create bevel effect--*/  
    border-bottom: 1px solid #444; /*--Create bevel effect--*/  
    clear: both;  
    width: 170px;  
}  
html ul.topnav li ul.subnav li a {  
    float: left;  
    width: 145px;  
    background: #333 url(dropdown_linkbg.gif) no-repeat 10px center;  
    padding-left: 20px;  
}  
html ul.topnav li ul.subnav li a:hover { /*--Hover effect for subnav links--*/  
    background: #222 url(dropdown_linkbg.gif) no-repeat 10px center;  
}  
</style>

</head>
<body>

<ul class="topnav">  
    <li><a href="#">Home</a></li>  
    <li>  
        <a href="#">Tutorials</a>  
        <ul class="subnav">  
            <li><a href="#">Sub Nav Link</a></li>  
            <li><a href="#">Sub Nav Link</a></li>  
        </ul>  
    </li>  
    <li>  
        <a href="#">Resources</a>  
        <ul class="subnav">  
            <li><a href="#">Sub Nav Link</a></li>  
            <li><a href="#">Sub Nav Link</a></li>  
        </ul>  
    </li>  
    <li><a href="#">About Us</a></li>  
    <li><a href="#">Advertise</a></li>  
    <li><a href="#">Submit</a></li>  
    <li><a href="#">Contact Us</a></li>  
</ul> 
</body>