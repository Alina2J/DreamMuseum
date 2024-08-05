<template>
        <li class="mb-3">
            <div class="form-outline">
                <textarea name="message" v-model="form.message" class="form-control" id="textAreaExample2" style="width: 850px" rows="4"></textarea>
            </div>
        </li>
        <button @keyup.enter="sendMessage" @click="sendMessage" type="button" class="btn-reset glow float-end">Отправить</button>
</template>

<script>

import {reactive} from "vue";
import useChat from "../composables/chat";
export default {
    name: "ChatForm",
    props: {
        id: {
            type: Number,
            required: true,
        },
    },
    setup(props) {

        const chatId = props.id;

        const form = reactive({
            message: '',
        });

        const {errors, addMessage} = useChat()

        const sendMessage = async () => {
            await addMessage(form, chatId)

            form.message = ''
        }

        return {
            errors,
            form,
            sendMessage,
            chatId
        }
    }
}
</script>

<style scoped>

</style>
