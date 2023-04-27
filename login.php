<!DOCTYPE html>
<html>
    <head>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">            
            <div class="row">                
                <div class="col-sm-6 col-md-4 col-md-offset-4">
                    <h1 class="text-center login-title">Logar Sistemas de Atas</h1>
                    <div class="account-wall">
                        <img class="profile-img" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120" alt="">
                        <form class="form-signin" action="class/logando.php" method="post">
                            <input type="text" name="login" id="login" class="form-control" placeholder="Login" required autofocus>
                            <input type="password" name="senha" id="senha" class="form-control" placeholder="Senha" required>
                            <button class="btn btn-lg btn-primary btn-block" type="submit">
                                Acessar</button>                            
                            <a href="#" class="pull-right need-help">Ajuda? </a><span class="clearfix"></span>
                        </form>
                    </div>
                    <!--<a href="#" class="text-center new-account">Create an account </a>-->
                </div>                
            </div>
        </div>
    </body>