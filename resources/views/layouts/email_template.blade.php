<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- So that mobile will display zoomed in -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- enable media queries for windows phone 8 -->
        <meta name="format-detection" content="telephone=no">
        <!-- disable auto telephone linking in iOS -->
        <title>{{ $siteSetting->site_name }}</title>
        <style type="text/css">
            body {
                margin: 0;
                padding: 0;
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
            }
            table {
                border-spacing: 0;
            }
            table td {
                border-collapse: collapse;
                font-family: sans-serif;
            }
            .col {
                padding: 5% 25%;
                background-color:#eeeeee47;
            }
            .button {
                color: #fff !important;
                text-decoration: none;
                background: #3140BE; 
                padding: 10px 20px;
                display: inline-block;
                margin: 40px;
                border-radius:3px;                
                font-size:14px;
            }
        
            table {
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
            }
            img {
                {{-- width: 25%; --}}
            }
            .soc {
                margin: 0px;
                padding: 0px;
                display: block;
            }
            .soc ul {
                margin: 0px;
                padding: 0px;
                float: left;
            }
            .soc ul li {
                list-style: none;
                float: left;
                margin: 0px 9px 0px 0px;
            }
            .header {                    
                padding: 12px !important;
                background-color:#E9FBFF;
                border-radius: 0.2rem 0.2rem 0rem 0rem;
                width:100%;
                border-left: solid 1px #d6d4d457;
                border-right: solid 1px #d6d4d457;
                border-top: solid 1px #d6d4d457;
            }
            .title {
                font-size: 18px;
                font-weight:500;
                padding-top: 5%;
                padding-bottom: 5%;
            }
            .subtitle {
                font-size: 10px;
                line-height: 16px;
                padding: 25px 28px;
                color: #949494;
            }
            .footer a {
                color: #aaaaaa !important;
                text-decoration: underline;
                display: block;
            }            
            .footer{
                font-size:11px;
                border-radius: 0rem 0rem 0.2rem 0.2rem;
                background-color: #0000000a;
                font-weight: 500;
                padding: 2%;
                border-left: solid 1px #d6d4d457;
                border-right: solid 1px #d6d4d457;
                border-bottom: solid 1px #d6d4d457;
            }

            .container {
                width: 100% !important;
                max-width: 100% !important;
                border-left: solid 1px #d6d4d457;
                border-right: solid 1px #d6d4d457;
            }
            .content-wrapper {
                font-size:14px;
            }
            
            @media (min-width: 320px) and (max-width: 480px) {
                img {
                    {{-- width: 32%; --}}
                } 
                .col {
                    padding: 5% 5%;
                }
                .title {
                    font-size: 12px;
                    padding-top: 10%;
                    padding-bottom: 5%;                    
                }
                .subtitle {
                    font-size: 8px;
                    line-height: 16px;
                    padding: 20px 15px;
                    color: #949494;
                }
                .footer {
                    font-size: 8px;
                }               
                .button{
                    font-size: 10px;
                    margin: 20px 0px 0px 0px;
                    padding: 5px;
                }
                .content-wrapper {
                    font-size: 9px;
                }
            }
            @media (min-width: 480px) and (max-width: 599px) {
                img {
                    {{-- width: 27%; --}}
                }
                .col {
                    padding: 5%;
                }
                .title {
                    font-size: 13px;
                    padding-top: 10%;
                    padding-bottom: 2%;                    
                }
                .subtitle {
                    font-size: 8px;
                    line-height: 16px;
                    padding: 20px 15px;
                    color: #949494;
                }
                .footer {
                    font-size: 8px;
                }
                .button {
                    font-size: 11px;
                    margin: 20px 0px;
                    padding: 5px 10px;
                }
                .content-wrapper {
                    font-size: 10px;
                }

            }

            @media (min-width: 599px) and (max-width: 768px) {
                img {
                    {{-- width: 22%; --}}
                }
                .col {
                    padding: 5%;
                }
                .title {
                    font-size: 14px;
                    padding-top: 5%;
                    padding-bottom: 2%;                    
                }
                .content-wrapper {
                    font-size: 11px;
                }
                .subtitle {
                    font-size: 8px;
                    line-height: 16px;
                    padding: 20px;
                    color: #949494;
                }
                .footer {
                    font-size: 8px;
                }
                .button{
                    font-size: 11px;
                    margin: 20px 0px;
                    padding: 6px 10px;
                }
            }

        </style>
    </head>
    <body style="margin:0; padding:0;" bgcolor="" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
        <!-- 100% background wrapper (grey background) -->        
        <table class="col" border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="">
           <tbody>
               <!-- header --->
                <tr>
                    <td class="header" align="center">
                        <a href="{{ url('/login') }}"><img src="{{ asset('/') }}sitesetting_images/thumb/{{ $siteSetting->site_logo }}" /></a>
                    </td>
                </tr>
                <!-- /header -->

                <!-- content -->
                <tr bgcolor="#FFF">
                    <td class="container" align="center"> @yield('content') </td>
                </tr>
                <!-- /content -->

                <!--- Footer--->
                <tr>
                    <td class="footer" align="center">
                        <span> © {{ date('Y')}} {{ $siteSetting->site_name }} - All Rights Reserved </span> 
                    </td>
                </tr>
                <!--- /Footer ---->
            </tbody>
        </table>
        <!--/100% background wrapper-->
    </body>
</html>