'use client';

import { Pagination, PaginationContent, PaginationItem, PaginationLink, PaginationNext, PaginationPrevious } from '@/components/ui/pagination';
import { useCategory } from '@/hooks/useCategory';
import { handleScrollProduct } from '@/lib/handle-scroll';
import { categoriesType, GameType, PaginatedResponse } from '@/types';
import { usePage } from '@inertiajs/react';
import axios from 'axios';
import { useCallback, useEffect, useRef, useState } from 'react';
import CardProduct from './card-product';
import NotFound from './not-found';
import ProductCardLoading from './product-card-loading';
import { Button } from './ui/button';

const Products = () => {
    const { games, categories } = usePage<{ games: GameType[]; categories: categoriesType[] }>().props;
    const { category: currentCategoryId } = useCategory();
    const [isLoading, setIsLoading] = useState(false);

    const [data, setData] = useState<PaginatedResponse<GameType>>(games as unknown as PaginatedResponse<GameType>);

    const cancelTokenRef = useRef(axios.CancelToken.source());

    // Fungsi fetch data yang bisa dibatalkan
    const fetchData = useCallback(
        async (page: number) => {
            // Cancel request sebelumnya jika masih berjalan
            cancelTokenRef.current.cancel('Request canceled due to new request');
            cancelTokenRef.current = axios.CancelToken.source();
            handleScrollProduct();

            try {
                setIsLoading(true);

                const endpoint = `?page=${page}&category=${currentCategoryId}`;
                const response = await axios.get(endpoint, {
                    cancelToken: cancelTokenRef.current.token,
                });

                setData(response.data);

                if (response.data) {
                    setIsLoading(false);
                }
            } catch (error) {
                setIsLoading(false);
                if (axios.isCancel(error)) {
                    // handle kalo Request dibatalkan
                } else {
                    console.error('Failed to fetch products:', error);
                }
            }
        },
        [currentCategoryId],
    );

    useEffect(() => {
        const loadData = async () => {
            setIsLoading(true);
            handleScrollProduct();

            try {
                await fetchData(1);
            } finally {
                setIsLoading(false);
            }
        };

        loadData();
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [currentCategoryId]);

    const currentCategory = categories.find((c) => c.id === currentCategoryId);

    return (
        <section className="space-y-4 px-2.5">
            <div>
                <h2 className="text-md font-medium capitalize">All Products 🔥</h2>
            </div>

            {data.data.length == 0 && !isLoading ? (
                <NotFound item={currentCategory?.name ?? 'product'} message="Mohon kembali lagi nanti atau explore produk lain." />
            ) : null}

            <div className="grid grid-cols-2 gap-2.5 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-8">
                {!isLoading ? (
                    <>
                        {data.data.map((game) => (
                            <CardProduct
                                key={game.id} // pakai id supaya stabil
                                title={game.name}
                                url={`/product/${game.category?.name}/${game.slug}`}
                                publisher={game.publisher}
                                image={`/storage/${game.image ?? '01JWNRWN1JN2AW6NSKP763Q5V1.jpeg'}`}
                            />
                        ))}
                    </>
                ) : (
                    [...Array(8)].map((_, index) => <ProductCardLoading key={index} />)
                )}
            </div>

            <Pagination>
                <PaginationContent className="text-primary hover:text-primary">
                    {/* Previous */}
                    <Button
                        onClick={() => fetchData(data.current_page - 1)}
                        className="text-accent-foreground bg-transparent hover:bg-transparent"
                        disabled={isLoading || !data.prev_page_url}
                    >
                        <PaginationItem>
                            <PaginationPrevious className={!data.prev_page_url ? 'text-muted' : ''} />
                        </PaginationItem>
                    </Button>

                    {/* Page Number Buttons */}
                    {Array.from({ length: data.last_page }, (_, idx) => {
                        const page = idx + 1;
                        return (
                            <Button key={page} onClick={() => fetchData(page)} disabled={data.current_page === page}>
                                <PaginationItem>
                                    <PaginationLink isActive={data.current_page === page}>{page}</PaginationLink>
                                </PaginationItem>
                            </Button>
                        );
                    })}

                    {/* Next */}
                    <Button
                        onClick={() => fetchData(data.current_page + 1)}
                        className="text-accent-foreground bg-transparent hover:bg-transparent"
                        disabled={isLoading || !data.next_page_url}
                    >
                        <PaginationItem>
                            <PaginationNext className={!data.next_page_url ? 'text-muted' : ''} />
                        </PaginationItem>
                    </Button>
                </PaginationContent>
            </Pagination>
        </section>
    );
};

export default Products;
