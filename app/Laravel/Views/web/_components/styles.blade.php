<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700%7COpen+Sans:400,600&display=swap" rel="stylesheet">

<link rel="stylesheet" href="{{asset('web/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('web/css/magnific-popup.css')}}">
<link rel="stylesheet" href="{{asset('web/css/themify-icons.css')}}">
<link rel="stylesheet" href="{{asset('web/css/all.min.css')}}">
<link rel="stylesheet" href="{{asset('web/css/animate.min.css')}}">
<link rel="stylesheet" href="{{asset('web/css/jquery.mb.YTPlayer.min.css')}}">
<link rel="stylesheet" href="{{asset('web/css/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('web/css/owl.theme.default.min.css')}}">
<link rel="stylesheet" href="{{asset('web/css/style.css')}}">
<link rel="stylesheet" href="{{asset('web/css/responsive.css')}}">
<link rel="stylesheet" href="{{asset('web/css/site.css?v=1.02')}}">

<style type="text/css">
    .bg-transparent.affix {background: rgba(29,29,31,0.72)!important; 
        -webkit-backdrop-filter: saturate(180%) blur(20px);
        backdrop-filter: saturate(180%) blur(20px);
    }
    .bottom-right{
        right: 200px;
        position: absolute;
        bottom: 0
    }
    .border-red{
        border-color: #dc3545;
    }

    .video-section-wrap .background-video-overly {
        display: flex;
        flex-direction: column;
        justify-content: center;
        background-image: linear-gradient(75deg, #1d1d1fDD 10%, #1d1d1fDD) !important;
        -webkit-backdrop-filter: saturate(50%) blur(3px);
        backdrop-filter: saturate(50%) blur(3px);
    }
    .gradient-overlay:before { 
        background-image: linear-gradient(75deg, #1d1d1fDD 10%, #1d1d1fDD) !important;
        -webkit-backdrop-filter: saturate(50%) blur(3px);
        backdrop-filter: saturate(50%) blur(3px); 
     }
    .gradient-bg {
    background: linear-gradient(75deg, #1d1d1f 10%, #1d1d1f) !important;
    }
    .bg-transparent ul li a{ opacity: .8; color: #f5f5f7; }

    .text-title{
        color: #254DA0 !important;
        font-size: 15px;
        
    }
    .text-title-two{
        color: #308CDC;
       
        
    }
    .text-uppercase{
        text-transform: uppercase;
    }
    .text-form{
        color: #000;
        font-weight: 600;
        font-size: 15px;
    }
    hr.form {
      border-top: 2px dashed #A5A5A5;
    }
    .br-left-white{
        border-left-color: #fff;
    }
    .br-right-white{
        border-right-color: #fff;
    }
    .border-none{
        border: none;
    }
    
    .fs-12{
        font-size: 12px;
    }
    .fs-14{
        font-size: 14px;
    }
    .fw-500{
        font-weight: 500;
    }
    .text-black{
        color: #000;
    }
    .custom-checkbox .custom-control-label::before {
        border: solid 2px #0235AA;
        height: 20px;
        width: 20px;
    }
    .custom-control-label::before {
       
        top: -0.2rem !important;
       
    }
    .custom-control-label::after {
        top: -0.3rem;
        left: -1.6rem;
        width: 1.5rem;
        height: 1.5rem;
    }

    select.classic {
        background-image:
        linear-gradient(45deg, transparent 50%, #0235AA 60%),
        linear-gradient(135deg, #0235AA 40%, transparent 50%) !important;
        background-position:calc(100% - 23px) 18px,calc(100% - 16px) 18px,100% 0;
        background-size:5px 8px,8px 5px;
        background-repeat: no-repeat;
        -webkit-appearance: none;
        -moz-appearance: none;
    }
    

    /*.menu li a { padding: 20px 30px; }
    .menu li a .badge{ font-size: 1em; padding: 7px 10px;} 
   
    body, h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6, p, .navbar, .brand, .btn, .btn-simple, a, .td-name, td,a.detail-link { font-family: 'SF Pro Display', sans-serif; }
    .outline-btn, .secondary-solid-btn, .primary-solid-btn, .solid-white-btn, .outline-white-btn, .secondary-outline-btn { font-family: 'SF Pro Display', sans-serif; }*/

    .team-section{ background: linear-gradient(75deg, #1d1d1f 10%, #1d1d1f); }
    .team-section h2,.team-section h5{ color: #f5f5f7; }
    .team-section p{ color: #a1a1a6; font-weight: 600; }

    .secondary-solid-btn {
        color: #f5f5f7;
        background: #27437D;
        border-radius: 8px;
        font-size:14px;
    }

    .secondary-solid-btn:hover {
        background: transparent;
        color: #1d1d1f;
        -webkit-box-shadow: none;
        box-shadow: none;
        border: 1px solid #1d1d1f;
    }
    .footer-bottom { background: #1d1d1f;}
    .footer-bottom a { color: #f5f5f7; }
    .footer-bottom a:hover { color: #fff; }

    .footer-nav-wrap h4 { font-weight: 600; }
    .footer-nav-wrap ul li a { color: #a1a1a6;}
    .footer-nav-wrap ul li a:hover { text-decoration: underline; color: #f5f5f7;  }
    .get-in-touch-list li{ color: #a1a1a6 }
    .lead{ font-weight: 600; }
    .single-blog-card a {
        font-weight: 600;
        font-family: 'SF Pro Display', sans-serif;
    }

    .services-single:hover{
        background: #1d1d1f!important; 
        color: #f5f5f7;
    }
    .services-single h5{ font-weight: 800; }

    .badge { font-family: 'SF Pro Display', sans-serif; font-weight: 400; }

    @media (max-width: 992px) and (min-width: 320px){
        .navbar {
            background: rgba(29,29,31,0.72)!important; 
            -webkit-backdrop-filter: saturate(180%) blur(20px);
            backdrop-filter: saturate(180%) blur(20px);
            padding: .45rem 1rem !important;
        }
        .menu li a { padding: 10px 10px; border-bottom: 1px solid #f1f1f155; }
        .menu li a:hover{ background: none; color: #fff; }
        .menu li:last-child a{ border-bottom: none; }
        .navbar-nav{ padding-top: 20px; }

        .menu li a .badge.badge-primary{ background-color: transparent!important;  padding: 0px;}
        .menu li a .badge.badge-primary i{ display: none; }

    }
    .brand-logo img{
        width: 150px;
    }
    .brand-logo{
        margin-bottom: 1.5em;
    }
    .profile-image{
        width: 32px;
        height: 32px;
        border-radius: 100%;
    }
    img.profile-image{
        vertical-align: middle;
        border-style: none;
    }

    .modal-header {
        background: #fff;
        border-bottom: none;
        position: relative;
        text-align: center;
        display: block;
        border-radius: 5px 5px 0 0;
        
    }
    .modal-header .icon-box {
        color: #fff;
        width: 95px;
        height: 95px;
        display: inline-block;
        border-radius: 50%;
        z-index: 9;
        border: 5px solid #fff;
        padding: 15px;
        text-align: center;
    }
    
</style>

<script src="{{asset('web/js/jquery-3.4.1.min.js')}}"></script>
<script src="{{asset('web/js/popper.min.js')}}"></script>
<script src="{{asset('web/js/bootstrap.min.js')}}"></script>