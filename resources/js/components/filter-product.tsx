import { useCategory } from '@/hooks/useCategory';
import { categoriesType } from '@/types';
import { usePage } from '@inertiajs/react';
import { Button } from './ui/button';
import { ScrollArea, ScrollBar } from './ui/scroll-area';

const FilterProduct = () => {
    const { categories } = usePage<{ categories: categoriesType[]; url: string }>().props;
    const { setCategory } = useCategory();

    return (
        <ScrollArea className="tab-category my-2 pb-4">
            <ul className="flex items-center space-x-4 p-4 pb-0">
                {categories.map(({ name, id }) => (
                    <li
                        key={id}
                        onClick={() => setCategory(id)}
                        className="font-barlow group text-accent-foreground relative inline-flex cursor-pointer justify-center overflow-hidden rounded-lg border-solid p-0.5 text-center text-base uppercase transition-transform duration-300 ease-in-out"
                    >
                        <Button variant={'outline'} className={`font-size text-xxs whitespace-nowrap capitalize`}>
                            {name}
                        </Button>
                        <span className="absolute top-0 left-[-75%] z-10 h-full w-[50%] rotate-12 bg-white/20 blur-lg transition-all duration-1000 ease-in-out group-hover:left-[125%]" />
                        <span className="drop-shadow-3xl border-accent-foreground absolute top-0 left-0 block h-[20%] w-1/2 rounded-tl-lg border-t-2 border-l-2 transition-all duration-300" />
                        <span className="drop-shadow-3xl border-accent-foreground absolute top-0 right-0 block h-[60%] w-1/2 rounded-tr-lg border-t-2 border-r-2 transition-all duration-300 group-hover:h-[90%]" />
                        <span className="drop-shadow-3xl border-accent-foreground absolute bottom-0 left-0 block h-[60%] w-1/2 rounded-bl-lg border-b-2 border-l-2 transition-all duration-300 group-hover:h-[90%]" />
                        <span className="drop-shadow-3xl border-accent-foreground absolute right-0 bottom-0 block h-[20%] w-1/2 rounded-br-lg border-r-2 border-b-2 transition-all duration-300" />
                    </li>
                ))}
            </ul>
            <ScrollBar orientation="horizontal" className="h-1" />
        </ScrollArea>
    );
};

export default FilterProduct;
