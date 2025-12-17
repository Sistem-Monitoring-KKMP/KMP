import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
// import { NavUser } from '@/components/nav-user';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes/index';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/react';
import { Folder, LayoutGrid, ChartColumnIncreasing, ChartPie, Map } from 'lucide-react';
import AppLogo from './app-logo';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Performa Organisasi',
        href: '/organization',
        icon: ChartPie,
    },
    {
        title: 'Performa Bisnis',
        href: '/business',
        icon: ChartColumnIncreasing,
    },
    {
        title: 'Sebaran Koperasi',
        href: '/distribution',
        icon: Map,
    },
    {
        title: 'Koperasi List',
        href: '/cooperatives',
        icon: Folder,
    },
];

const footerNavItems: NavItem[] = [];

export function AppSidebar() {
    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href={dashboard()} prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavFooter items={footerNavItems} className="mt-auto" />
                {/* <NavUser /> */}
            </SidebarFooter>
        </Sidebar>
    );
}
