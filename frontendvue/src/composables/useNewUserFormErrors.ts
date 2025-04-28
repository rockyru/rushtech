import { reactive } from 'vue';


export function useNewUserFormErrors() {

    const formErrors = reactive<Record<string, string[]>>({});

    function setErrors(errors: Record<string, string[]>) {
        Object.assign(formErrors, errors);

       setTimeout(() => {       
            Object.keys(formErrors).forEach((key) => {
                delete formErrors[key];
            });
        }
        , 1500);
    }

    function removeFieldError(field: string) {
        if (formErrors[field]) {
            delete formErrors[field];
        }
    }

    function resetErrors() {
        Object.keys(formErrors).forEach((key) => {
            delete formErrors[key];
        });
    }

    return {
        formErrors,
        setErrors,
        removeFieldError,
        resetErrors
    };

}