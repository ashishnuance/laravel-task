<template>
    
    <div>
        <ul>
            <li></li>
        </ul>
        <input type="text" v-model="message" @keyup.enter="sendMessage">
        <ul>
            <li v-for="(msg, index) in messages" :key="index">{{ msg }}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                message: '',
                messages: []
            };
        },
        mounted() {
            Echo.channel('chat')
                .listen('NewMessage', (event) => {
                    this.messages.push(event.message);
                });
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
