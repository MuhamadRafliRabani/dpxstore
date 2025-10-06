import { CategoryState } from '@/types';
import { create } from 'zustand';

export const useCategory = create<CategoryState>((set) => ({
    category: 1,
    setCategory: (state: number) => set({ category: state }),
}));
