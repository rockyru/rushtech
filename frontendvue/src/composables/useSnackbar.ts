import { ref } from "vue";

export function useSnackbar() { 

    const show = ref(false);
    const message = ref("");
    const variant = ref("success");

    function successVariant(msg: string) {
        show.value = true;
        message.value = msg;
        variant.value = "success";
    }

    function errorVariant(msg: string) { 
        show.value = true;
        message.value = msg;
        variant.value = "error";
    }

    return {
        show,
        message,
        variant,
        successVariant,
        errorVariant,
    }
}