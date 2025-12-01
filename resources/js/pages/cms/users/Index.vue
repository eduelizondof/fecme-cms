<script setup lang="ts">
import DataTable from '@/components/cms/DataTable.vue';
import ChangePasswordDialog from '@/components/cms/ChangePasswordDialog.vue';
import DeleteConfirmDialog from '@/components/cms/DeleteConfirmDialog.vue';
import Pagination from '@/components/cms/Pagination.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { Edit, KeyRound, Power, PowerOff, Trash2 } from 'lucide-vue-next';
import { computed, ref } from 'vue';

interface User {
    id: number;
    name: string;
    email: string;
    is_active: boolean;
    created_at: string;
}

interface Props {
    users: {
        data: User[];
        links: any[];
        from: number;
        to: number;
        total: number;
    };
}

defineProps<Props>();

const page = usePage();
const currentUserId = computed(() => page.props.auth?.user?.id);

const columns = [
    { key: 'name', label: 'Nombre' },
    { key: 'email', label: 'Email' },
    { key: 'is_active', label: 'Estado' },
    { key: 'created_at', label: 'Creado' },
];

const deleteDialog = ref(false);
const passwordDialog = ref(false);
const selectedId = ref<number | null>(null);
const selectedUserName = ref<string>('');

const openDeleteDialog = (id: number) => {
    selectedId.value = id;
    deleteDialog.value = true;
};

const openPasswordDialog = (id: number, name: string) => {
    selectedId.value = id;
    selectedUserName.value = name;
    passwordDialog.value = true;
};

const toggleUserStatus = (user: User) => {
    if (confirm(`¿Estás seguro de que deseas ${user.is_active ? 'inactivar' : 'activar'} a ${user.name}?`)) {
        router.patch(`/cms/users/${user.id}/toggle-status`);
    }
};

const formatDate = (dateString: string | null | undefined): string => {
    if (!dateString) {
        return 'Sin fecha';
    }
    
    const date = new Date(dateString);
    
    if (isNaN(date.getTime()) || date.getFullYear() === 1970) {
        return 'Sin fecha';
    }
    
    return date.toLocaleDateString('es-MX', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        timeZone: 'America/Mexico_City',
    });
};

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Usuarios', href: '/cms/users' },
];
</script>

<template>
    <Head title="Usuarios - CMS" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <DataTable
                title="Usuarios"
                :columns="columns"
                :data="users.data"
                create-route="/cms/users/create"
                edit-route="/cms/users/:id/edit"
                delete-route="/cms/users/:id"
                create-label="Crear usuario"
                @delete="openDeleteDialog"
            >
                <template #cell-is_active="{ value, item }">
                    <div class="flex items-center gap-2">
                        <Badge 
                            :variant="value ? 'default' : 'secondary'"
                            :class="value ? 'bg-green-500 text-white hover:bg-green-600' : ''"
                        >
                            {{ value ? 'Activo' : 'Inactivo' }}
                        </Badge>
                        <Button
                            v-if="item.id !== currentUserId"
                            variant="ghost"
                            size="icon"
                            class="h-6 w-6"
                            @click="toggleUserStatus(item)"
                            :title="value ? 'Inactivar usuario' : 'Activar usuario'"
                        >
                            <PowerOff v-if="value" class="h-3 w-3" />
                            <Power v-else class="h-3 w-3" />
                        </Button>
                    </div>
                </template>
                <template #cell-created_at="{ value }">
                    {{ formatDate(value) }}
                </template>
                <template #actions="{ item }">
                    <div class="flex items-center gap-2">
                        <Button
                            variant="ghost"
                            size="icon"
                            @click="openPasswordDialog(item.id, item.name)"
                            title="Cambiar contraseña"
                        >
                            <KeyRound class="h-4 w-4" />
                        </Button>
                        <Link :href="`/cms/users/${item.id}/edit`">
                            <Button variant="ghost" size="icon" title="Editar">
                                <Edit class="h-4 w-4" />
                            </Button>
                        </Link>
                        <Button
                            variant="ghost"
                            size="icon"
                            class="text-destructive hover:text-destructive"
                            @click="openDeleteDialog(item.id)"
                            title="Eliminar"
                        >
                            <Trash2 class="h-4 w-4" />
                        </Button>
                    </div>
                </template>
            </DataTable>

            <Pagination
                :links="users.links"
                :from="users.from"
                :to="users.to"
                :total="users.total"
            />

            <DeleteConfirmDialog
                v-model:open="deleteDialog"
                :delete-url="selectedId ? `/cms/users/${selectedId}` : undefined"
                title="Eliminar usuario"
                description="¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer."
            />

            <ChangePasswordDialog
                v-model:open="passwordDialog"
                :user-id="selectedId"
                :user-name="selectedUserName"
            />
        </div>
    </AppLayout>
</template>
