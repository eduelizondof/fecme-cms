<script setup lang="ts">
import LogoEditor from '@/components/cms/settings/LogoEditor.vue';
import CtaButtonEditor from '@/components/cms/settings/CtaButtonEditor.vue';
import MenuItemsEditor from '@/components/cms/settings/MenuItemsEditor.vue';
import SocialLinksEditor from '@/components/cms/settings/SocialLinksEditor.vue';
import ContactInfoEditor from '@/components/cms/settings/ContactInfoEditor.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    headerSettings: Record<string, any>;
    footerSettings: Record<string, any>;
}>();

const headerForm = useForm({
    logo: props.headerSettings.logo || {},
    ctaButton: props.headerSettings.ctaButton || { enabled: true, label: '', href: '' },
    menuItems: props.headerSettings.menuItems || [],
    socialLinks: props.headerSettings.socialLinks || [],
    contactInfo: props.headerSettings.contactInfo || {},
});

const footerForm = useForm({
    logo: props.footerSettings.logo || {},
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
                                <LogoEditor v-model="headerForm.logo" />
                                <p v-if="headerForm.errors.logo" class="mt-2 text-sm text-destructive">
                                    {{ headerForm.errors.logo }}
                                </p>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Botón CTA</CardTitle>
                                <CardDescription>Configuración del botón de llamada a la acción</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <CtaButtonEditor v-model="headerForm.ctaButton" />
                                <p v-if="headerForm.errors.ctaButton" class="mt-2 text-sm text-destructive">
                                    {{ headerForm.errors.ctaButton }}
                                </p>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Menú de Navegación</CardTitle>
                                <CardDescription>Elementos del menú principal</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <MenuItemsEditor v-model="headerForm.menuItems" />
                                <p v-if="headerForm.errors.menuItems" class="mt-2 text-sm text-destructive">
                                    {{ headerForm.errors.menuItems }}
                                </p>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Redes Sociales</CardTitle>
                                <CardDescription>Enlaces a redes sociales</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <SocialLinksEditor v-model="headerForm.socialLinks" />
                                <p v-if="headerForm.errors.socialLinks" class="mt-2 text-sm text-destructive">
                                    {{ headerForm.errors.socialLinks }}
                                </p>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Información de Contacto</CardTitle>
                                <CardDescription>Datos de contacto mostrados en el sitio</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <ContactInfoEditor v-model="headerForm.contactInfo" />
                                <p v-if="headerForm.errors.contactInfo" class="mt-2 text-sm text-destructive">
                                    {{ headerForm.errors.contactInfo }}
                                </p>
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
                                <LogoEditor v-model="footerForm.logo" />
                                <p v-if="footerForm.errors.logo" class="mt-2 text-sm text-destructive">
                                    {{ footerForm.errors.logo }}
                                </p>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Información del Footer</CardTitle>
                                <CardDescription>Nombre y leyenda del footer</CardDescription>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="space-y-2">
                                    <Label for="footer-name">Nombre de la organización</Label>
                                    <Input
                                        id="footer-name"
                                        v-model="footerForm.name"
                                        placeholder="Federación Canina de México gt. A.C."
                                    />
                                    <p v-if="footerForm.errors.name" class="text-sm text-destructive">
                                        {{ footerForm.errors.name }}
                                    </p>
                                </div>

                                <div class="space-y-2">
                                    <Label for="footer-legend">Leyenda</Label>
                                    <Input
                                        id="footer-legend"
                                        v-model="footerForm.legend"
                                        placeholder="Reconocidos mundialmente por la WKU y FECAM"
                                    />
                                    <p v-if="footerForm.errors.legend" class="text-sm text-destructive">
                                        {{ footerForm.errors.legend }}
                                    </p>
                                </div>
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
