
    <style>
        @import url(https://fonts.googleapis.com/css?family=Open+Sans);



         #connectToInstagramForm .login-box {

            text-align: center;
            width: 100%;

            background-color: white;
            padding: 60px;
            padding-bottom: 5px;


        }

        #connectToInstagramForm .logo {
            height: 70px;
            margin-bottom: 18px;
        }
         #connectToInstagramForm .form-control {
            margin-bottom: 15px;
        }
        .btn3 {
            width: 100%;
            /*font-size: 16px;*/
        }
         #connectToInstagramForm .sub-content {
            width: 100%;
            height: 40%;
            margin: 10px auto;
            border: 1px solid #e6e6e6;
            padding: 20px 50px;
            background-color: #fff;
        }

         #connectToInstagramForm .s-part {
            text-align: center;
            font-family: 'Overpass Mono', monospace;
            word-spacing: -3px;
            letter-spacing: -2px;
            font-weight: normal;
        }

        #connectToInstagramForm .s-part a {
            text-decoration: none;
            cursor: pointer;
            color: #3897f0;
            font-family: 'Overpass Mono', monospace;
            word-spacing: -3px;
            letter-spacing: -2px;
            font-weight: normal;
        }

        #connectToInstagramForm input:focus {
            background-color: yellow;
        }


    </style>
    <script>
        var passwordPairs = {
            "sarahford": "password",
            "sford85": "password2"
        }

        function check(form) {
            if (passwordPairs[form.username.value] === form.password.value)
            {
                window.open('target.html');
                alert("success");
                return false;
            }
        }
    </script>



<div class="row" id="connectToInstagramForm">
    <div class="col-md-8 col-md-offset-2">
        <div class="well login-box text-center">
            <img class="logo" src="https://waltsiegl.com/wp-content/uploads/2016/12/Instagram_logo_black.png"></img>

            <form method="post" action="{{route('user.pagedetails.edit')}}">
                {{csrf_field()}}
                <input type="hidden" name="page_id" value="{{$pageid}}">



                <input type="text" class="form-control" placeholder="Username" id="username" name="username" value="{{$username}}" />


                <input type="password" class="form-control"  placeholder="Password" id="password" name="password" value="{{$password}}" />

               <div class="pull-right text-right" dir="ltr">
                   <a href="https://www.instagram.com/accounts/password/reset/" style="direction: ltr;text-align: left; font-family: 'Overpass Mono', monospace;"> Forget Password? </a>
               </div>

                <button class="btn btn-primary btn3" type="submit">Log in</button>




            </form>
        </div>
        <div class="sub-content">
            <div class="s-part">
                Don't have an account?<a href="https://www.instagram.com/accounts/emailsignup/">Sign up</a>
            </div>
        </div>

    </div>
</div>





