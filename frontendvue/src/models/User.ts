export interface User {
    first_name: string;
    last_name: string;
    email: string;
    role: string;
    roles?: string;
    permissions: string[];
    id: number | null;
    username: string;
    phone: string;
    address: string;
    postal_code: string;
    password?: string;
    password_confirmation: string;
}