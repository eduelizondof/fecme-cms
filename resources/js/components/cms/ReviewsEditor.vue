<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Plus, Star, Trash2 } from 'lucide-vue-next';
import { computed } from 'vue';

interface Review {
    author: string;
    rating: number;
    comment: string;
    date: string;
}

interface Props {
    modelValue: Review[];
    label?: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: () => [],
    label: 'Reseñas',
});

const emit = defineEmits<{
    'update:modelValue': [value: Review[]];
}>();

const reviews = computed({
    get: () => props.modelValue || [],
    set: (value) => emit('update:modelValue', value),
});

const addReview = () => {
    reviews.value = [...reviews.value, { 
        author: '', 
        rating: 5, 
        comment: '', 
        date: new Date().toISOString().split('T')[0] 
    }];
};

const removeReview = (index: number) => {
    const newReviews = [...reviews.value];
    newReviews.splice(index, 1);
    reviews.value = newReviews;
};

const updateReview = (index: number, field: keyof Review, value: any) => {
    const newReviews = [...reviews.value];
    newReviews[index] = { ...newReviews[index], [field]: value };
    reviews.value = newReviews;
};

const setRating = (index: number, rating: number) => {
    updateReview(index, 'rating', rating);
};
</script>

<template>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <Label v-if="label" class="text-base font-medium">{{ label }}</Label>
            <Button
                type="button"
                variant="outline"
                size="sm"
                @click="addReview"
                class="gap-1"
            >
                <Plus class="h-4 w-4" />
                Agregar reseña
            </Button>
        </div>

        <div v-if="reviews.length === 0" class="text-sm text-muted-foreground py-6 text-center border border-dashed rounded-lg">
            <Star class="h-8 w-8 mx-auto mb-2 opacity-50" />
            <p>No hay reseñas registradas.</p>
        </div>

        <div v-else class="space-y-4">
            <div
                v-for="(review, index) in reviews"
                :key="index"
                class="p-4 border rounded-lg bg-card"
            >
                <div class="flex items-center justify-between mb-3 pb-2 border-b">
                    <span class="text-sm font-medium">Reseña #{{ index + 1 }}</span>
                    <Button
                        type="button"
                        variant="ghost"
                        size="icon"
                        class="h-8 w-8 text-muted-foreground hover:text-destructive"
                        @click="removeReview(index)"
                    >
                        <Trash2 class="h-4 w-4" />
                    </Button>
                </div>

                <div class="space-y-4">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="space-y-2">
                            <Label class="text-sm">Autor</Label>
                            <Input
                                :model-value="review.author"
                                @update:model-value="updateReview(index, 'author', $event)"
                                placeholder="Nombre del autor"
                            />
                        </div>
                        <div class="space-y-2">
                            <Label class="text-sm">Fecha</Label>
                            <Input
                                type="date"
                                :model-value="review.date"
                                @update:model-value="updateReview(index, 'date', $event)"
                            />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <Label class="text-sm">Calificación</Label>
                        <div class="flex items-center gap-1">
                            <button
                                v-for="star in 5"
                                :key="star"
                                type="button"
                                class="p-1 hover:scale-110 transition-transform"
                                @click="setRating(index, star)"
                            >
                                <Star 
                                    class="h-6 w-6" 
                                    :class="star <= review.rating ? 'fill-yellow-400 text-yellow-400' : 'text-gray-300'"
                                />
                            </button>
                            <span class="ml-2 text-sm text-muted-foreground">{{ review.rating }}/5</span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <Label class="text-sm">Comentario</Label>
                        <Textarea
                            :model-value="review.comment"
                            @update:model-value="updateReview(index, 'comment', $event)"
                            placeholder="Escribe el comentario de la reseña..."
                            :rows="3"
                        />
                    </div>
                </div>
            </div>
        </div>

        <p class="text-xs text-muted-foreground">
            {{ reviews.length }} reseña(s)
        </p>
    </div>
</template>

