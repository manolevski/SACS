var sacs = {

    User: function(name, email, token, allow) {
        var self = this;
        self.name = name;
        self.email = email;
        self.token = token;
        self.allow = ko.observable(allow === 'true');
    },

    UsersViewModel: function(data) {
        var self = this;

        self.newName = ko.observable();
        self.newEmail = ko.observable();

        self.users = ko.observableArray([]);
        for (var key in data) {
            if (!data.hasOwnProperty(key)) continue;

            var obj = data[key];
            self.users.push(new sacs.User(obj.name, obj.email, obj.token, obj.allow))
        }

        self.addUser = function() {
            self.users.push(new sacs.User(self.newName(), self.newEmail(), self.token(), "false"));
            self.newName("");
            self.newEmail("");
            self.saveChanges();
        }

        self.removeUser = function(user) { 
            self.users.remove(user);
            self.saveChanges();
        }

        self.changeStatus = function() {
            self.saveChanges();            
            return true;
        }

        self.token = function() {
            var min = 80603140213;      //11111111
            var max = 2821109907455;    //zzzzzzzz
            var random = Math.floor(Math.random() * (max - min + 1)) + min;
            return random.toString(36);
        };

        self.saveChanges = function() {
            var data = ko.toJS({"users":self.users});
            
            $.ajax({
                url: "save.php",
                type: 'post',
                data: data    
            });
        }
    }
};
