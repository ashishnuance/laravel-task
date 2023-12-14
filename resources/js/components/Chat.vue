<template>
    
    <div>
        <div class="row" style="height:70vh">
            <div class="col-md-3">
                <ul>
                    <li>alskdamsjd</li>
                    <li>alskdamsjdas hdvas</li>
                    <li>alskda</li>
                    <li>alasd asd</li>
                </ul>
            </div>
            <div class="col-md-9">
                <input type="text" v-model="message" @keyup.enter="sendMessage">
                <ul>
                    <li>alsdjbanmsdna,m sdansd asd</li>
                    <li v-for="(msg, index) in messages" :key="index">{{ msg }}</li>
                </ul>
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
                messages: []
            };
        },
        mounted() {
            window.Echo = new Echo({
                broadcaster: 'pusher',
                key: '5c875ee5042b7ca5673e',
                cluster: 'ap2',
                // Other options...
            });
            // window.Echo.channel('notifications').listen('NewNotification', (data) => {
            //     this.notifications.push(data.message);
            // });

            window.Echo.channel('chat').listen('NewMessage', (data) => {
                console.log('data',data);
                this.messages.push(data.message);
            });
            /*window.Echo.channel('chat')
                .listen('NewMessage', (event) => {
                    this.messages.push(event.message);
                    console.log(this.messages);
                });
                */
        },
        methods: {
            sendMessage() {
                axios.post('/send-message', { message: this.message })
                    .then(response => {
                        console.log(response.data);
                        this.message = '';
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        }
    };
</script>
