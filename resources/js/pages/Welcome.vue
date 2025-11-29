<script setup lang="ts">
import { login } from '@/routes';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Welcome" />
    <div class="flex min-h-screen flex-col items-center justify-center bg-white">
        <!-- Logo centrado -->
        <div class="mb-12">
            <img src="/img/logo.svg" alt="Logo" class="h-32 w-auto" />
        </div>

        <!-- Botón grande: Volver a fecmemx.com -->
        <div class="mb-8">
            <a
                href="https://fecmemx.com"
                target="_blank"
                class="inline-block rounded-lg bg-gray-900 px-8 py-4 text-lg font-semibold text-white transition-colors hover:bg-gray-800"
            >
                Volver a fecmemx.com
            </a>
        </div>

        <!-- Botón pequeño escondido: Ingresar -->
        <div class="absolute bottom-4 right-4">
            <Link
                :href="login()"
                class="text-xs text-gray-400 opacity-50 transition-opacity hover:opacity-100"
            >
                Ingresar
            </Link>
        </div>
    </div>
</template>
