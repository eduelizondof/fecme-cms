<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarGroup,
    SidebarGroupLabel,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import {
    LayoutGrid,
    FileText,
    Briefcase,
    Building2,
    Award,
    Calendar,
    GraduationCap,
    Users,
    Settings,
} from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
];

const cmsNavItems: NavItem[] = [
    {
        title: 'Blog',
        href: '/cms/blogs',
        icon: FileText,
    },
    {
        title: 'Servicios',
        href: '/cms/services',
        icon: Briefcase,
    },
    {
        title: 'Criaderos',
        href: '/cms/breeders',
        icon: Building2,
    },
    {
        title: 'Certificados',
        href: '/cms/certificates',
        icon: Award,
    },
    {
        title: 'Eventos',
        href: '/cms/events',
        icon: Calendar,
    },
    {
        title: 'Escuelas',
        href: '/cms/schools',
        icon: GraduationCap,
    },
    {
        title: 'Jueces',
        href: '/cms/judges',
        icon: Users,
    },
    {
        title: 'Sitio web',
        href: '/cms/settings',
        icon: Settings,
    },
];

const footerNavItems: NavItem[] = [
   
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
            <SidebarGroup class="px-2 py-0">
                <SidebarGroupLabel>Módulos</SidebarGroupLabel>
                <SidebarMenu>
                    <SidebarMenuItem v-for="item in cmsNavItems" :key="item.title">
                        <SidebarMenuButton
                            as-child
                            :tooltip="item.title"
                        >
                            <Link :href="item.href">
                                <component :is="item.icon" />
                                <span>{{ item.title }}</span>
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarGroup>
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
