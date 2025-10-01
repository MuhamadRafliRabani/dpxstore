'use client';

import { Appearance, useAppearance } from '@/hooks/use-appearance';
import { Monitor, Moon, Sun } from 'lucide-react';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from './ui/select';

export default function ThemeSelector({ mobile = false }: { mobile: boolean }) {
    const { appearance, updateAppearance } = useAppearance();

    const iconMap = {
        light: <Sun className="h-5 w-5" />,
        dark: <Moon className="h-5 w-5" />,
        system: <Monitor className="h-5 w-5" />,
    } as const;

    return (
        <Select value={appearance} onValueChange={(value) => updateAppearance(value as Appearance)}>
            <SelectTrigger className={`text-primary ${mobile ? 'w-10' : 'hidden w-10 md:inline-block md:w-[41px]'}`}>
                <SelectValue>
                    <h1 className="text-primary">{iconMap[appearance]}</h1>
                </SelectValue>
            </SelectTrigger>
            <SelectContent>
                <SelectGroup>
                    <SelectLabel>Pilih Tema</SelectLabel>
                    <SelectItem value="light" className="selectItem">
                        <Sun className="text-primary hover:text-primary size-4" /> Light
                    </SelectItem>
                    <SelectItem value="dark" className="selectItem">
                        <Moon className="text-primary hover:text-primary size-4" /> Dark
                    </SelectItem>
                    <SelectItem value="system" className="selectItem">
                        <Monitor className="text-primary hover:text-primary size-4" /> System
                    </SelectItem>
                </SelectGroup>
            </SelectContent>
        </Select>
    );
}
