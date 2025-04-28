import type { User } from './User';

export interface AuthState {
    user: User | null;
    token: string | null;
    role: string | null;
    roles: string[] | null;
}
