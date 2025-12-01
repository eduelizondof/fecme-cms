<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

interface FaqItem {
    id: number;
    question: string;
    answer: string;
    is_active: boolean;
    display_order: number;
}

const props = defineProps<{
    faq: FaqItem;
}>();

const form = useForm({
    question: props.faq.question || '',
    answer: props.faq.answer || '',
    is_active: props.faq.is_active !== undefined ? props.faq.is_active : false,
    display_order: props.faq.display_order || 0,
});

const submit = () => {
    form.put(`/cms/faq/${props.faq.id}`);
};

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Nosotros', href: '/cms/about' },
    { title: 'FAQ', href: '/cms/faq' },
    { title: 'Editar', href: `/cms/faq/${props.faq.id}/edit` },
];
</script>

<template>
    <Head :title="`Editar FAQ - CMS`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold tracking-tight">Editar Pregunta Frecuente</h2>
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
                                <div class="flex items-center gap-2">
                                    <input
                                        id="is_active"
                                        v-model="form.is_active"
                                        type="checkbox"
                                        class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary"
                                    />
                                    <Label for="is_active">Activo</Label>
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
                        {{ form.processing ? 'Guardando...' : 'Guardar cambios' }}
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

