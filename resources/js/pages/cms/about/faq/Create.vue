<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    question: '',
    answer: '',
    is_active: false,
    display_order: 0,
});

const submit = () => {
    form.post('/cms/faq');
};

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Nosotros', href: '/cms/about' },
    { title: 'FAQ', href: '/cms/faq' },
    { title: 'Crear', href: '/cms/faq/create' },
];
</script>

<template>
    <Head title="Crear FAQ - CMS" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold tracking-tight">Crear Pregunta Frecuente</h2>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div class="grid gap-6 lg:grid-cols-3">
                    <div class="lg:col-span-2 space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Información básica</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="space-y-2">
                                    <Label for="question">Pregunta *</Label>
                                    <Textarea
                                        id="question"
                                        v-model="form.question"
                                        placeholder="Escribe la pregunta"
                                        :rows="3"
                                    />
                                    <p v-if="form.errors.question" class="text-sm text-destructive">
                                        {{ form.errors.question }}
                                    </p>
                                </div>

                                <div class="space-y-2">
                                    <Label for="answer">Respuesta *</Label>
                                    <Textarea
                                        id="answer"
                                        v-model="form.answer"
                                        placeholder="Escribe la respuesta"
                                        :rows="6"
                                    />
                                    <p v-if="form.errors.answer" class="text-sm text-destructive">
                                        {{ form.errors.answer }}
                                    </p>
                                </div>
                            </CardContent>
                        </Card>
                    </div>

                    <div class="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Configuración</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <Label for="is_active">Activo</Label>
                                    <Switch
                                        id="is_active"
                                        :checked="form.is_active"
                                        @update:checked="form.is_active = $event"
                                    />
                                </div>

                                <div class="space-y-2">
                                    <Label for="display_order">Orden de visualización</Label>
                                    <Input
                                        id="display_order"
                                        v-model.number="form.display_order"
                                        type="number"
                                        min="0"
                                    />
                                </div>
                            </CardContent>
                        </Card>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <Button
                        type="button"
                        variant="outline"
                        @click="$inertia.visit('/cms/faq')"
                    >
                        Cancelar
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Guardando...' : 'Crear FAQ' }}
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

