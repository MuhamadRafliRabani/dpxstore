'use client';

import { GameType, SearchType } from '@/types';
import { Link } from '@inertiajs/react';
import { Search, X } from 'lucide-react';
import { useEffect, useState } from 'react';
import { useDebounce } from 'use-debounce';
import NotFound from './not-found';
import { Card } from './ui/card';
import { Input } from './ui/input';
import Image from './ui/loading-image';
import { ScrollArea } from './ui/scroll-area';

const GameSearchSelect = ({ search, showSearch, cardSearch, setShowSearch }: SearchType) => {
    const [searchValue, setSearchValue] = useState('');
    const [debouncedSearch] = useDebounce(searchValue, 400);
    const [results, setResults] = useState<GameType[] | null>(null);
    const isMobile = typeof window !== 'undefined' && window.innerWidth < 768;

    const handleCloseCard = () => {
        setSearchValue('');
        setShowSearch(false);
    };

    useEffect(() => {
        if (!debouncedSearch) {
            setResults(null);
            return;
        }

        const fetchGames = async () => {
            try {
                const res = await fetch(`/search?q=${debouncedSearch}`);
                const data = await res.json();
                setResults(data);
            } catch (err) {
                console.error(err);
            }
        };

        fetchGames();
    }, [debouncedSearch]);

    return (
        <div
            ref={search}
            className="absolute inset-x-0 top-15 z-5 mx-auto hidden h-full max-h-[400px] w-full max-w-11/12 items-center justify-center overflow-hidden rounded md:static md:flex md:h-[40px] md:max-h-[40px]"
        >
            <div className="relative h-full max-h-[40px] w-full md:max-h-full">
                <Search className="text-primary/70 absolute top-[45%] left-3 size-4 -translate-y-1/2" />
                <Input
                    type="text"
                    name="q"
                    value={searchValue}
                    onChange={(e) => setSearchValue(e.target.value)}
                    placeholder="Cari Game atau Voucher"
                    className="text-primary placeholder:text-primary/70 w-full bg-gray-700 py-2 ps-8 text-sm placeholder:text-xs"
                />
                {searchValue != '' && (
                    <X className="text-primary/80 absolute top-[45%] right-3 size-4 -translate-y-1/2" onClick={() => handleCloseCard()} />
                )}
            </div>
            {searchValue != '' ? (
                !results ? (
                    <Card className="absolute inset-x-0 top-9 z-4 mx-auto h-full max-h-[350px] w-full overflow-hidden border-none px-10 pb-0 shadow-none md:top-12 md:-left-7 md:max-w-[28rem] lg:max-w-[60rem]">
                        <div className="hover:bg-muted/10 container grid grid-cols-6 gap-4">
                            <div className="size-12 animate-pulse place-items-center rounded bg-black/30 object-cover md:size-15" />
                            <div className="col-span-5 space-y-2">
                                <div className="col-span-2 h-6 w-full animate-pulse rounded bg-black/30 font-medium"></div>
                                <div className="h-4 w-full animate-pulse rounded bg-black/30"></div>
                            </div>
                        </div>
                    </Card>
                ) : (
                    <Card
                        ref={cardSearch}
                        className="absolute inset-x-0 top-9 z-4 mx-auto h-full max-h-[350px] w-full overflow-hidden border-none pb-0 shadow-none md:top-12 md:-left-7 md:max-w-[20rem] lg:max-w-[60rem]"
                    >
                        <ScrollArea data-lenis-prevent type="always" className="h-fit max-h-[340px] w-full overflow-y-auto px-4 pb-8 md:h-[400px]">
                            <div className="space-y-4 pb-4">
                                {results?.length == 0 && (
                                    <div className="flex items-center justify-center">
                                        <NotFound item="Games" message="Tidak ada hasil untuk pencarianmu ..." />
                                    </div>
                                )}

                                {results?.map((game, index) => (
                                    <Link
                                        href={`/product/${game.category?.name}/${game.slug}`}
                                        key={index}
                                        className="hover:bg-muted/10 flex items-center gap-4"
                                    >
                                        <Image src={'/storage/' + game.image} className="size-12 rounded object-cover md:size-15" />
                                        <div>
                                            <div className="text-primary text-sm font-medium md:text-base">{game.name}</div>
                                            <div className="text-primary/70 text-xs md:text-sm">{game.publisher}</div>
                                        </div>
                                    </Link>
                                ))}
                            </div>
                        </ScrollArea>
                    </Card>
                )
            ) : null}
        </div>
    );
};

export default GameSearchSelect;
