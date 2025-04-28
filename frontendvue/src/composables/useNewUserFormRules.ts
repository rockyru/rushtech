export const useNewUserFormRules = (password: string) => { 

    return {
        required: (value: any) => !!value || 'This field is required',
        email: (value: string) => /.+@.+\..+/.test(value) || 'E-mail must be valid',
        minPasswordLength: (value: string) => (value && value.length >= 6) || 'Password must be at least 6 characters',
        passwordMatch: (value: string) => value === password || 'Passwords do not match',
        usernameLength: (value: string) => (value && value.length >= 5) || 'Username must be at least 5 characters',
    }

}