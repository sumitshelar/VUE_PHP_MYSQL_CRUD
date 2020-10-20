<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Vue</title>
    <script src="vue.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <style>
        #err_msg {
            color: red;
        }

        .modal-mask {
            position: fixed;
            z-index: 9998;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, .5);
            display: table;
            transition: opacity .3s ease;
        }

        .modal-wrapper {
            display: table-cell;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div id="app">
        <div class="container" style="margin-top:18px;">
            <div class="row">
                <div class="col-md-6">
                    <h5>Insert Data here</h5>
                    <form id="create_item">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" placeholder="Enter First Name" v-model.trim='new_item.firstName'>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" placeholder="Enter Last Name" v-model.trim='new_item.lastName'>
                        </div>

                        <div class="form-group">
                            <label>Profession</label><input class="form-control" placeholder="Enter Your Profession" v-model.trim='new_item.profession'></div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" placeholder="Enter Email" v-model.trim='new_item.email'>
                        </div>

                    </form><button v-bind:disabled='btn_switch' @click='create_item'> Create</button>
                </div>
                <div class="col-md-6">
                    <div class="data" id="list" v-if='usr_info_set.length'>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">First Name</th>
                                    <th scope="col">Last Name</th>
                                    <th scope="col">Profession</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for='element in usr_info_set'>
                                    <th scope="row">{{element.first_name}}</th>
                                    <td scope="row">{{element.last_name}}</td>
                                    <td>{{element.profession}}</td>
                                    <td>{{element.email_id}}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="...">
                                            <!--                                            <button  @click="showModal = true" class="btn btn-warning" id="edit_user" title="Edit"><i class="fa fa-pencil"></i></button>-->
                                            <button @click="start_edit(element)" class="btn btn-warning" id="edit_user" title="Edit"><i class="fa fa-pencil"></i></button>
                                            <button @click="delete_usr(element.user_id)" class="btn btn-danger" id="del_user"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p id="err_msg" v-else>{{err_msg}}</p>
                </div>
            </div>
        </div>

        <!-- The Modal -->
 <!--       <div id="myModal" class="modal">


            <div class="modal-content">
                <span class="close">&times;</span>
                <form id="create_item">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" placeholder="Enter First Name" v-model.trim='new_item.firstName'>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Enter Last Name" v-model.trim='new_item.lastName'>
                    </div>

                    <div class="form-group">
                        <label>Profession</label><input class="form-control" v-model.trim='new_item.profession'></div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" v-model.trim='new_item.email'>
                    </div>

                </form><button @click='save_edit'> Create</button>
            </div>

        </div>-->

        <div v-if="showModal">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Modal title</h4>
                                    <button type="button" class="close" @click="showModal=false">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="create_item">
                                        <div class="form-group">
                                            <label>First Name {{edited_item.first_name}}</label>
                                            <input type="text" class="form-control" placeholder="Enter First Name" v-model.trim='edited_item.first_name'>
                                        </div>
                                        <div class="form-group">
                                            <label>Last Name {{edited_item.last_name}}</label>
                                            <input type="text" class="form-control"  placeholder="Enter Last Name" v-model.trim='edited_item.last_name'>
                                        </div>

                                        <div class="form-group">
                                            <label>Profession {{edited_item.profession}}</label><input class="form-control" v-model.trim='edited_item.profession'></div>
                                        <div class="form-group">
                                            <label>Email {{edited_item.email_id}}</label>
                                            <input type="text" class="form-control" v-model.trim='edited_item.email_id'>
                                        </div>

                                    </form><button v-bind:disabled='save_switch' @click='save_edit'> Create</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>


    <script>
        var vm = new Vue({
            el: '#app',
            data: {
                showModal: false,
                new_item: {
                    firstName: '',
                    lastName: '',
                    profession: '',
                    email: ''
                },
                usr_info_set: [],
                err_msg: 'Loading',
                url: 'api.php',
                edited_item:null,
            },
            computed: {
                btn_switch: function() {
                    if (this.new_item.firstName.length >= 1 && this.new_item.lastName.length >= 1 && this.new_item.profession.length >= 1 && this.new_item.email.length >= 1) {
                        return false;
                    } else {
                        return true;
                    }
                },
                save_switch: function() {
                    if (this.edited_item.first_name.length >= 1 && this.edited_item.last_name.length >= 1 && this.edited_item.profession.length >= 1 && this.edited_item.email_id.length >= 1) {
                        return false;
                    } else {
                        return true;
                    }
                }
            },
            created: function() {
                this.retrieve_all();
            },
            methods: {
                start_edit: function(element) {
                    this.showModal = true
                    console.log(element)
                    this.edited_item = element
                },
                save_edit: function() {
                    this.showModal = false
                    var self = this;
                    $.post({
                            url: self.url,
                            data: {
                                action: 'update_item',
                                edited_item: self.edited_item
                            }
                        })
                        .always(function(data) {
                            self.usr_info_set = [], //compulsary
                                self.err_msg = '' //optional
                        })
                        .done(function(data) {
                            var result = JSON.parse(data)
                            if (result[0]) {
                                self.retrieve_all()
                            } else {
                                self.err_msg = result[1]
                            }
                        })
                        .fail(function(data) {
                            self.err_msg = data.statusText
                        })
                },
                create_item: function() {
                    var self = this;
                    $.post({
                            url: self.url,
                            data: {
                                action: 'create_item',
                                new_item: self.new_item
                            }
                        })
                        .always(function(data) {
                            self.usr_info_set = [], //compulsary
                                self.err_msg = '' //optional
                        })
                        .done(function(data) {
                            var result = JSON.parse(data)
                            if (result[0]) {
                                self.retrieve_all()
                            } else {
                                self.err_msg = result[1]
                            }
                        })
                        .fail(function(data) {
                            self.err_msg = data.statusText
                        })

                },
                retrieve_all: function() {
                    var self = this;
                    $.ajax({
                            url: self.url,
                            method: 'POST',
                            data: {
                                action: 'retrieve_all'
                            }
                        })
                        .always(function(data) {
                            self.usr_info_set = [], //compulsary
                                self.err_msg = '' //optional
                        })
                        .done(function(data) {
                            var result = JSON.parse(data);
                            console.log(result);
                            if (result[0]) {
                                self.usr_info_set = result[1]
                            } else {
                                self.err_msg = result[1]
                            }
                        })
                        .fail(function(data) {
                            self.err_msg = data.statusText
                        })
                },
                delete_usr: function(user_id) {
                    //                    console.log(user_id)
                    var self = this;
                    $.post({
                            url: self.url,
                            data: {
                                action: 'delete_user',
                                user_id: user_id
                            }
                        })
                        .always(function(data) {
                            self.usr_info_set = [], //compulsary
                                self.err_msg = '' //optional
                        })
                        .done(function(data) {
                            var result = JSON.parse(data)
                            if (result[0]) {
                                self.retrieve_all()
                            } else {
                                self.err_msg = result[1]
                            }
                        })
                        .fail(function(data) {
                            self.err_msg = data.statusText
                        })
                }
            }
        })
    </script>
</body>

</html>
<!--communicate and connect jQuery with database-->
<!--instantialting XMLHttpRequest Obj.-->
<!--sending Request -->
<!--receiving responses-->