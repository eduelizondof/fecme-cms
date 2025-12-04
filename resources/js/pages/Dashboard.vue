<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { 
    Image, 
    FileImage, 
    CheckSquare, 
    Save,
    Eye,
    FileText,
    Lightbulb
} from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4"
        >
            <!-- Welcome Section -->
            <Card>
                <CardHeader class="text-center">
                    <div class="flex justify-center mb-4">
                        <img 
                            src="/img/logo.svg" 
                            alt="Logo" 
                            class="h-24 w-auto object-contain"
                        />
                    </div>
                    <CardTitle class="text-3xl font-bold">
                        ¡Bienvenido al Panel de Administración!
                    </CardTitle>
                    <CardDescription class="text-base mt-2">
                        En este sistema administrarás el contenido de tu sitio web. 
                        Aquí podrás gestionar todas las secciones, imágenes, textos y 
                        configuraciones necesarias para mantener tu sitio actualizado.
                    </CardDescription>
                </CardHeader>
            </Card>

            <!-- Tips Section -->
            <Card>
                <CardHeader>
                    <CardTitle class="flex items-center gap-2">
                        <Lightbulb class="h-5 w-5" />
                        Consejos para una mejor gestión
                    </CardTitle>
                    <CardDescription>
                        Sigue estas recomendaciones para optimizar el contenido de tu sitio web
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                        <!-- Tip 1: Image Testing -->
                        <div class="flex gap-3 p-4 rounded-lg border bg-muted/50">
                            <div class="flex-shrink-0 mt-1">
                                <Eye class="h-5 w-5 text-primary" />
                            </div>
                            <div class="flex-1 space-y-1">
                                <h4 class="font-semibold text-sm">Verifica las imágenes</h4>
                                <p class="text-sm text-muted-foreground">
                                    Cuando cambies una imagen, asegúrate de verificar que se ajuste 
                                    correctamente en diferentes dispositivos y tamaños de pantalla.
                                </p>
                            </div>
                        </div>

                        <!-- Tip 2: Image Quality -->
                        <div class="flex gap-3 p-4 rounded-lg border bg-muted/50">
                            <div class="flex-shrink-0 mt-1">
                                <FileImage class="h-5 w-5 text-primary" />
                            </div>
                            <div class="flex-1 space-y-1">
                                <h4 class="font-semibold text-sm">Calidad de imágenes</h4>
                                <p class="text-sm text-muted-foreground">
                                    Utiliza imágenes de buena calidad (alta resolución). 
                                    Esto mejora la experiencia visual de tus visitantes.
                                </p>
                            </div>
                        </div>

                        <!-- Tip 3: Image Formats -->
                        <div class="flex gap-3 p-4 rounded-lg border bg-muted/50">
                            <div class="flex-shrink-0 mt-1">
                                <Image class="h-5 w-5 text-primary" />
                            </div>
                            <div class="flex-1 space-y-1">
                                <h4 class="font-semibold text-sm">Formatos recomendados</h4>
                                <p class="text-sm text-muted-foreground">
                                    Prefiere formatos como JPG para fotos y PNG para imágenes con 
                                    transparencia. El formato WebP ofrece mejor compresión.
                                </p>
                            </div>
                        </div>

                        <!-- Tip 4: Save Changes -->
                        <div class="flex gap-3 p-4 rounded-lg border bg-muted/50">
                            <div class="flex-shrink-0 mt-1">
                                <Save class="h-5 w-5 text-primary" />
                            </div>
                            <div class="flex-1 space-y-1">
                                <h4 class="font-semibold text-sm">Guarda tus cambios</h4>
                                <p class="text-sm text-muted-foreground">
                                    No olvides guardar los cambios después de realizar modificaciones. 
                                    Revisa todo antes de publicar.
                                </p>
                            </div>
                        </div>

                        <!-- Tip 5: Content Structure -->
                        <div class="flex gap-3 p-4 rounded-lg border bg-muted/50">
                            <div class="flex-shrink-0 mt-1">
                                <FileText class="h-5 w-5 text-primary" />
                            </div>
                            <div class="flex-1 space-y-1">
                                <h4 class="font-semibold text-sm">Organiza el contenido</h4>
                                <p class="text-sm text-muted-foreground">
                                    Mantén el contenido bien estructurado y organizado. 
                                    Usa títulos descriptivos y textos claros.
                                </p>
                            </div>
                        </div>

                        <!-- Tip 6: Preview -->
                        <div class="flex gap-3 p-4 rounded-lg border bg-muted/50">
                            <div class="flex-shrink-0 mt-1">
                                <CheckSquare class="h-5 w-5 text-primary" />
                            </div>
                            <div class="flex-1 space-y-1">
                                <h4 class="font-semibold text-sm">Revisa antes de publicar</h4>
                                <p class="text-sm text-muted-foreground">
                                    Siempre revisa cómo se ve el contenido en el sitio público 
                                    antes de considerarlo finalizado.
                                </p>
                            </div>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
