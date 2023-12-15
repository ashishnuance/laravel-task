<template>
    
    <div>
        <div class="row">
            <div class="col-md-3">
                <ul class="user-list">
                    <li><a href="/chat">All users</a></li>
                    <li v-for="user in users[0]" :key="user.id">
                    <a v-bind:href="`?u=${user.id}`">{{user.name}}</a>
                    
                    </li>
                </ul>
            </div>
            <div class="col-md-9">
                

                
                <ul class="chat-section">
                    <li class="left clearfix" v-for="message in messages" :key="message.id">
                    <div class="clearfix">
                        <div class="header">
                        <strong>
                            {{ message.user.name }}
                        </strong>
                        </div>
                        <p>
                        {{ message.message_text }}
                        </p>
                    </div>
                    </li>
                </ul>
                <div class="message-input-box">
                    <input type="text" class="form-control" v-model="message" @keyup.enter="sendMessage">
                    <span class="input-group-btn">
                        <button class="btn btn-primary btn-sm" id="btn-chat" @click="sendMessage">Send</button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Echo from 'laravel-echo';
    export default {
        data() {
            return {
                message: '',
                messages: [],
                users: []
            };
        },
        mounted() {

            // window.Echo = new Echo({
            //     broadcaster: 'pusher',
            //     key: '5c875ee5042b7ca5673e',
            //     cluster: 'ap2',
            //     // Other options...
            // });

            // window.Echo.channel('notifications').listen('NewNotification', (data) => {
            //     this.notifications.push(data.message);
            // });
            console.log('data');    
            window.Echo.channel('chat').listen('NewMessage', function(data) {
                console.log('data', data);
                this.messages.push(data.message);
            }.bind(this));

            /*window.Echo.channel('chat')
                .listen('NewMessage', (event) => {
                    this.messages.push(event.message);
                    console.log(this.messages);
                });
                */
            this.fetchMessages();
            this.fetchUsers();
        },
        methods: {
            fetchMessages() {
                //GET request to fetch all the messages
                axios.get('/messages').then(response => {
                    //Save the response in the messages array to display on the chat view
                    this.messages = response.data;
                    console.log('response',this.messages);
                });
            },

            fetchUsers() {
                //GET request to fetch all the users
                axios.get('/user-list').then(response => {
                    // console.log('userlist',response);
                    //Save the response in the users array to display on the chat view
                    this.users = response.data;
                    console.log('response',this.users);
                });
            },

            
            
            sendMessage() {
                if(this.message!=''){
                axios.post('/send-message', { message: this.message })
                    .then(response => {
                        console.log(response.data);
                        this.fetchMessages();
                        this.message = '';
                    })
                    .catch(error => {
                        console.error(error);
                    });
                }
            }
        }
    };
</script>
