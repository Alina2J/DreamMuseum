<template>
    <div>
    <li class="d-flex justify-content-between mb-4" v-for="message in messages">
        <img :src="'/storage/' + message.user.photo_url" alt="avatar"
             class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
        <div class="card w-100">
            <div  :class="{'bg-secondary bg-gradient text-white': message.user.id !== user.id}" class="card-header d-flex justify-content-between p-3">
                <p class="fw-bold mb-0">{{ message.user.login}}</p>
                <p class="small mb-0">{{ message.creation_date}}</p>
            </div>
            <div class="card-body">
                <p class="mb-0">
                    {{ message.message }}
                </p>
            </div>
        </div>
    </li>
    </div>
</template>

<script>
import useChat from '../composables/chat';
import {onMounted} from 'vue';

export default {
    name: 'ChatMessages',
    props: {
        user: {
            required: true,
            type: Object,
            default: () => ({})
        },
        chatId: { required: true, type: Number },
    },
    setup(props) {
        const {messages, getMessages} = useChat()
        const chatId = props.chatId;

        onMounted(() => {
            getMessages(chatId);
            this.user = JSON.parse(this.user);
        });

        Echo.private('chat')
            .listen('MessageSent', (e) => {
                messages.value.push({
                    message: e.message.message,
                    user: e.user
                });
            });

        return {
            messages
        }
    }
};

</script>

<style scoped>

</style>


