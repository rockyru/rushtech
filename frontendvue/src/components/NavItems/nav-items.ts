export interface NavItem {
    title: string;
    to: string;
    roles: string[];
}

export const navItems: NavItem[] = [
    {
        title: 'Dashboard',
        to: '/dashboard',
        roles: ['admin', 'user'],
    },
    {
        title: 'Manage Users',
        to: '/manage-users',
        roles: ['admin'],
    },
    {
        title: 'Profile',
        to: '/profile',
        roles: ['admin', 'user'],
    }
]