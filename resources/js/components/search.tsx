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
    const [searchValue, setSearchValue] = useState<string | undefined>('');
    const [isLoading, setIsLoading] = useState<boolean>(false);
    const [debouncedSearch] = useDebounce(searchValue, 400);
    const [results, setResults] = useState<GameType[] | null>(null);

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
            setIsLoading(true);
            try {
                const res = await fetch(`/search?q=${debouncedSearch}`);
                const data = await res.json();
                setResults(data);
            } catch (err) {
                console.error(err);
                setIsLoading(false);
            }
            setIsLoading(false);
        };

        fetchGames();
    }, [debouncedSearch]);

    return (
        <div
            ref={search}
            className="absolute inset-x-0 top-15 z-5 mx-auto hidden h-full max-h-[400px] w-full max-w-11/12 items-center justify-center overflow-hidden rounded md:static md:flex md:max-h-[40px]"
        >
            <div className="relative mx-auto h-full w-full sm:w-11/12">
                <Search className="text-primary/70 absolute top-[45%] left-3 size-4 -translate-y-1/2" />
                <Input
                    type="text"
                    name="q"
                    value={searchValue}
                    onChange={(e) => setSearchValue(e.target.value)}
                    placeholder="Cari Game atau Voucher"
                    className="text-primary placeholder:text-primary/70 bg-accent-foreground/10 w-full py-2 ps-8 text-sm placeholder:text-xs sm:text-2xl sm:placeholder:text-sm"
                />
                {searchValue != '' && (
                    <X className="text-primary/80 absolute top-[45%] right-3 size-4 -translate-y-1/2" onClick={() => handleCloseCard()} />
                )}
            </div>
            {searchValue != '' ? (
                isLoading || !results ? (
                    <Card className="absolute inset-x-0 top-9 z-4 mx-auto h-full max-h-[350px] w-full -space-y-2 overflow-hidden border-none px-4 pb-0 shadow-none sm:top-12 sm:-left-7 sm:max-w-[29rem] lg:max-w-[55rem]">
                        {[...Array(5)].map(() => (
                            <div className="hover:bg-muted/10 container grid grid-cols-6 space-x-4 sm:w-11/12">
                                <div className="bg-accent-foreground/40 size-12 animate-pulse place-items-center rounded object-cover sm:size-14" />
                                <div className="col-span-5 space-y-1 sm:mt-2">
                                    <div className="bg-accent-foreground/40 col-span-2 h-5 w-full animate-pulse rounded font-medium"></div>
                                    <div className="bg-accent-foreground/40 h-4 w-3/4 animate-pulse rounded"></div>
                                </div>
                            </div>
                        ))}
                    </Card>
                ) : (
                    <Card
                        ref={cardSearch}
                        className="absolute inset-x-0 top-9 z-4 mx-auto h-full max-h-[350px] w-full overflow-hidden border-none pb-0 shadow-none sm:top-12 sm:-left-7 sm:max-w-[29rem] lg:max-w-[55rem]"
                    >
                        <ScrollArea type="always" className="h-fit max-h-[340px] w-full overflow-y-auto px-4 pb-8 sm:h-[400px]">
                            <div className="space-y-4 pb-4">
                                {results?.length == 0 && (
                                    <div className="flex items-center justify-center sm:h-[300px]">
                                        <NotFound item="Games" message="Tidak ada hasil untuk pencarianmu ..." />
                                    </div>
                                )}

                                {results?.map((game, index) => (
                                    <Link
                                        href={`/product/${game.category?.name.toLowerCase()}/${game.slug}`}
                                        key={index}
                                        className="hover:bg-muted/10 flex items-center gap-4"
                                    >
                                        <Image src={'/storage/' + game.image} className="size-12 rounded object-cover md:size-15" />
                                        <div>
                                            <div className="text-primary text-sm font-medium sm:text-base">{game.name}</div>
                                            <div className="text-primary/70 text-xs sm:text-sm">{game.publisher}</div>
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
