<script setup lang="ts">
import JsonEditor from '@/components/cms/JsonEditor.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    headerSettings: Record<string, any>;
    footerSettings: Record<string, any>;
}>();

const headerForm = useForm({
    logo: props.headerSettings.logo || null,
    ctaButton: props.headerSettings.ctaButton || null,
    menuItems: props.headerSettings.menuItems || [],
    socialLinks: props.headerSettings.socialLinks || [],
    contactInfo: props.headerSettings.contactInfo || null,
});

const footerForm = useForm({
    logo: props.footerSettings.logo || null,
    name: props.footerSettings.name || '',
    legend: props.footerSettings.legend || '',
});

const submitHeader = () => {
    headerForm.put('/cms/settings/header');
};

const submitFooter = () => {
    footerForm.put('/cms/settings/footer');
};

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Configuración', href: '/cms/settings' },
];
</script>

<template>
    <Head title="Configuración del Sitio - CMS" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold tracking-tight">Configuración del Sitio</h2>
            </div>

            <Tabs default-value="header" class="w-full">
                <TabsList>
                    <TabsTrigger value="header">Header</TabsTrigger>
                    <TabsTrigger value="footer">Footer</TabsTrigger>
                </TabsList>

                <TabsContent value="header">
                    <form @submit.prevent="submitHeader" class="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Logo</CardTitle>
                                <CardDescription>Configuración del logo del sitio</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <JsonEditor
                                    v-model="headerForm.logo"
                                    label=""
                                    :rows="8"
                                    placeholder='{ "src": "/img/logo.png", "alt": "Logo", "title": "...", "height": "80px", "width": "80px", "href": "/" }'
                                />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Botón CTA</CardTitle>
                                <CardDescription>Configuración del botón de llamada a la acción</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <JsonEditor
                                    v-model="headerForm.ctaButton"
                                    label=""
                                    :rows="6"
                                    placeholder='{ "label": "Validar certificado", "href": "/validar-certificado", "enabled": true }'
                                />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Menú de Navegación</CardTitle>
                                <CardDescription>Elementos del menú principal</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <JsonEditor
                                    v-model="headerForm.menuItems"
                                    label=""
                                    :rows="20"
                                />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Redes Sociales</CardTitle>
                                <CardDescription>Enlaces a redes sociales</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <JsonEditor
                                    v-model="headerForm.socialLinks"
                                    label=""
                                    :rows="12"
                                />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Información de Contacto</CardTitle>
                                <CardDescription>Datos de contacto mostrados en el sitio</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <JsonEditor
                                    v-model="headerForm.contactInfo"
                                    label=""
                                    :rows="15"
                                />
                            </CardContent>
                        </Card>

                        <div class="flex justify-end">
                            <Button type="submit" :disabled="headerForm.processing">
                                {{ headerForm.processing ? 'Guardando...' : 'Guardar Header' }}
                            </Button>
                        </div>
                    </form>
                </TabsContent>

                <TabsContent value="footer">
                    <form @submit.prevent="submitFooter" class="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle>Logo del Footer</CardTitle>
                                <CardDescription>Configuración del logo en el footer</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <JsonEditor
                                    v-model="footerForm.logo"
                                    label=""
                                    :rows="8"
                                    placeholder='{ "src": "/img/logo-blanco.png", "alt": "Logo", "title": "...", "width": "150", "height": "150", "href": "/" }'
                                />
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Información del Footer</CardTitle>
                                <CardDescription>Nombre y leyenda del footer</CardDescription>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <JsonEditor
                                    v-model="footerForm.name"
                                    label="Nombre de la organización"
                                    :rows="2"
                                    placeholder='"Federación Canina de México gt. A.C."'
                                />
                                <JsonEditor
                                    v-model="footerForm.legend"
                                    label="Leyenda"
                                    :rows="2"
                                    placeholder='"Reconocidos mundialmente por la WKU y FECAM"'
                                />
                            </CardContent>
                        </Card>

                        <div class="flex justify-end">
                            <Button type="submit" :disabled="footerForm.processing">
                                {{ footerForm.processing ? 'Guardando...' : 'Guardar Footer' }}
                            </Button>
                        </div>
                    </form>
                </TabsContent>
            </Tabs>
        </div>
    </AppLayout>
</template>

