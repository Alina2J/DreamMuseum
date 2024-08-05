import {ref} from 'vue';
import axios from 'axios';

export default function useChat() {
    const messages = ref([])
    const errors = ref([])

    async function getMessages(chatId) {
        await axios.get(`/messages/${chatId}`).then((response) => {
            messages.value = response.data.filter((message) => {
                return message.chat_id === chatId; // фильтруем сообщения для выбранного чата
            });
        })
    }

    const addMessage = async (form, chatId) => {
        errors.value = [];

        // проверяем chatId на соответствие Id чата
        if (!Number.isInteger(chatId) || chatId <= 0) {
            errors.value.push('Invalid chatId.');
            return;
        }

        try {
            await axios.post(`/chats/${chatId}/send`, form).then((response) => {
                messages.value.push(response.data)
            })
        } catch (e) {
            if(e.response.status === 422) {
                errors.value = e.response.data.errors
            }
        }
    }

    return {
      messages,
      errors,
      getMessages,
      addMessage
    }
}
