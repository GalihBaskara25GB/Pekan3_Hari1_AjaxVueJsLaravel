<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajax with VueJs and Laravel</title>
</head>

<body>
    <div id="app">
            
        <div>
            <br>
            <input type="text" placeholder="Type a name..." v-model="form.name">
            <button v-show="!updateSubmit" @click.prevent="add">Add</button>
            <button v-show="updateSubmit" @click.prevent="update">Update</button>
            <br>
        </div>

        <ul v-for="(user, index) in users">
            <li>
                <span>@{{user.name}}</span>
                <button @click="edit(user, index)">Edit</button> || 
                <button @click="del(user, index)">Delete</button>
            </li>
        </ul>

    </div>

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.6/vue.js"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                users: [],
                updateSubmit: false,
                form: {
                        'name' : ''
                    },
                selectedUserId: null,  
            },
            mounted() {
                axios.get('/api/user/')
                    .then(response => {
                        this.users = response.data.data
                    })
                    .catch(err => {
                        console.error(err);
                    })
                ;
            },
            methods: {
                add() {
                    if(this.form.name == '') {
                        alert('Enter a name...');
                        return
                    }
                    axios.post(`/api/user`, {'name': this.form.name}).then(response => {
                        if(response.status == 201) {
                            this.users.push(this.form)
                            this.form = {}
                            return true

                        } else {
                            alert('Failed to Save Data !!')
                            return false

                        }
                    })
                },
                edit(user, index) {
                    this.selectedUserId = index
                    this.updateSubmit = true
                    this.form.name = user.name 
                },
                update() {
                    axios.post(`/api/user/update/${this.users[this.selectedUserId].id}`, {'name': this.form.name}).then(response => {
                        if(response.status == 200) {            
                            this.users[this.selectedUserId].name = this.form.name
                            this.form = {}
                            this.updateSubmit = false
                            this.selectedUserId = null
                            return true

                        } else {
                            alert('Failed to Update !!')
                            return false

                        }
                    })
                },
                del(user, index){
                    if(!confirm('Are you sure you want to delete data ??')) return false
                    axios.delete(`api/user/delete/${user.id}`).then(response => {
                        if(response.status == 200) {   
                            this.users.splice(index, 1)
                            return true

                        } else {
                            alert('Failed to Delete !!')
                            return false
                            
                        }
                    })
                }
            }
        });
    </script>
</body>
</html>