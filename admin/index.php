<!DOCTYPE html>
<html lang="en">
    <head>
        <title>SACS</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/knockout/knockout-3.1.0.js" type="text/javascript"></script>

        <script src="js/index.js" defer></script>

        <link href="starter-template.css" rel="stylesheet">
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">                
                    <h3>Simple Access Control Service</h3>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="starter-template">
                <table class='table table-striped'>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Access token</th>
                        <th>Allow access</th>                        
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody data-bind="foreach: users">
                    <tr>
                        <td><span data-bind="text: name"></span></td>
                        <td><span data-bind="text: email"></span></td>
                        <td><span data-bind="text: token"></span></td>
                        <td><input data-bind="checked: allow, click: $parent.changeStatus" type='checkbox'></td>
                        <td><a href="#" data-bind="click: $parent.removeUser"><i class="fa fa-trash-o icon-button" aria-hidden="true"></i></a></td>
                    </tr>    
                </tbody>
                </table>
                <input data-bind="value: newName" placeholder="Name" />
                <input data-bind="value: newEmail" placeholder="Email" />
                <button data-bind="click: addUser">Add user</button>
            </div>
        </div>
        <div class="navbar navbar-fixed-bottom">
            <div class="container">
                <span class="pull-right">Code by Anastas Manolevski</span>
            </div>
        </div>
    <script>
        var data = <?php $data=file_get_contents("../user_data.json"); echo $data; ?> ;
        $(function(){
            
            var usersVM = new sacs.UsersViewModel(data);
            ko.applyBindings(usersVM);
        });
    </script>
    </body>
</html>
