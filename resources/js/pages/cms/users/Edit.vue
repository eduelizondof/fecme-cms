<script setup lang="ts">
import ChangePasswordDialog from '@/components/cms/ChangePasswordDialog.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { KeyRound } from 'lucide-vue-next';
import { ref } from 'vue';

interface User {
    id: number;
    name: string;
    email: string;
    is_active: boolean;
}

const props = defineProps<{
    user: User;
}>();

const form = useForm({
    name: props.user.name || '',
    email: props.user.email || '',
    is_active: props.user.is_active !== undefined ? props.user.is_active : true,
});

const passwordDialog = ref(false);

const submit = () => {
    form.put(`/cms/users/${props.user.id}`);
};

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Usuarios', href: '/cms/users' },
    { title: 'Editar', href: `/cms/users/${props.user.id}/edit` },
];
</script>

<template>
    <Head :title="`Editar: ${user.name} - CMS`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold tracking-tight">Editar Usuario</h2>
                <Button
                    variant="outline"
                    @click="passwordDialog = true"
                >
                    <KeyRound class="mr-2 h-4 w-4" />
                    Cambiar contraseña
                </Button>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div class="grid gap-6 lg:grid-cols-3">
                    <div class="lg:col-span-2 space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Información del usuario</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="space-y-2">
                                    <Label for="name">Nombre *</Label>
                                    <Input
                                        id="name"
                                        v-model="form.name"
                                        placeholder="Nombre completo"
                                        required
                                    />
                                    <p v-if="form.errors.name" class="text-sm text-destructive">
                                        {{ form.errors.name }}
                                    </p>
                                </div>

                                <div class="space-y-2">
                                    <Label for="email">Email *</Label>
                                    <Input
                                        id="email"
                                        v-model="form.email"
                                        type="email"
                                        placeholder="usuario@ejemplo.com"
                                        required
                                    />
                                    <p v-if="form.errors.email" class="text-sm text-destructive">
                                        {{ form.errors.email }}
                                    </p>
                                </div>
                            </CardContent>
                        </Card>
                    </div>

                    <div class="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Estado</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <Label for="is_active">Usuario activo</Label>
                                    <Switch
                                        id="is_active"
                                        :checked="form.is_active"
                                        @update:checked="form.is_active = $event"
                                    />
                                </div>
                                <p class="text-xs text-muted-foreground">
                                    Los usuarios inactivos no podrán iniciar sesión en el sistema.
                                </p>
                            </CardContent>
                        </Card>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <Button
                        type="button"
                        variant="outline"
                        @click="$inertia.visit('/cms/users')"
                    >
                        Cancelar
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Guardando...' : 'Guardar cambios' }}
                    </Button>
                </div>
            </form>

            <ChangePasswordDialog
                v-model:open="passwordDialog"
                :user-id="user.id"
                :user-name="user.name"
            />
        </div>
    </AppLayout>
</template>
