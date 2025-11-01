import { columns } from '@/components/list-harga/columns';
import { DataTable } from '@/components/list-harga/data-table';
import { Button } from '@/components/ui/button';
import { Pagination, PaginationContent, PaginationItem, PaginationNext, PaginationPrevious } from '@/components/ui/pagination';
import AppLayout from '@/layouts/app-layout';
import { PaginatedResponse, ProductType } from '@/types';
import { usePage } from '@inertiajs/react';
import axios from 'axios';
import { memo, useRef, useState } from 'react';

const ListHarga = memo(() => {
    const { products: initProducts } = usePage<{ products: PaginatedResponse<ProductType> }>().props;
    const [products, setProducts] = useState<PaginatedResponse<ProductType>>(initProducts);

    const [isLoading, setIsLoading] = useState(false);
    console.log('🚀 ~ products:', products);

    const cancelTokenRef = useRef(axios.CancelToken.source());

    // Fungsi fetch data yang bisa dibatalkan
    const fetchData = async (page: number) => {
        // Cancel request sebelumnya jika masih berjalan
        cancelTokenRef.current.cancel('Request canceled due to new request');
        cancelTokenRef.current = axios.CancelToken.source();

        try {
            setIsLoading(true);

            const endpoint = `/list-harga/?page=${page}`;
            const response = await axios.get(endpoint, {
                cancelToken: cancelTokenRef.current.token,
            });

            setProducts(response.data);

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
    };

    return (
        <AppLayout>
            <div className="my-4 w-full px-2">
                <h1 className="text-md font-medium sm:text-lg">List Harga 🔥</h1>
                <h3 className="text-accent-foreground/70 sm:text-md text-sm font-medium">Berikut adalah list harga terkini</h3>
            </div>
            <section className="space-y-6 px-1">
                {products.data.map((group, i) => (
                    <DataTable
                        key={i}
                        id={group.id}
                        columns={columns}
                        data={group.product_item}
                        title={group.name}
                        image={`/storage/${group.image}`}
                    />
                    // <PaginatedTable key={i} columns={columns} data={group.items} title={group.gameName} image={`/storage/games/${group.gameImage}`} />
                ))}

                <Pagination>
                    <PaginationContent className="text-accent-foreground hover:text-primary">
                        {/* Previous */}
                        <Button
                            onClick={() => {
                                let current_page = 0;

                                if (products?.current_page) {
                                    current_page = products.current_page;
                                }

                                fetchData(current_page - 1);
                            }}
                            className="text-accent-foreground bg-transparent hover:bg-transparent"
                            disabled={isLoading || !products?.prev_page_url}
                        >
                            <PaginationItem>
                                <PaginationPrevious className={`sm:text-base ${!products?.prev_page_url ? 'text-muted' : ''}`} />
                            </PaginationItem>
                        </Button>

                        {/* Page Number Buttons */}
                        {/* {Array.from({ length: products.last_page }, (_, idx) => {
                        const page = idx + 1;
                        return (
                            <Button key={page} onClick={() => fetchData(page)} disabled={products.current_page === page}>
                                <PaginationItem>
                                    <PaginationLink isActive={products.current_page === page}>{page}</PaginationLink>
                                </PaginationItem>
                            </Button>
                        );
                    })} */}

                        {/* Next */}
                        <Button
                            onClick={() => {
                                let current_page = 0;

                                if (products?.current_page) {
                                    current_page = products.current_page;
                                }

                                fetchData(current_page + 1);
                            }}
                            className="text-accent-foreground bg-transparent hover:bg-transparent"
                            disabled={isLoading || !products?.next_page_url}
                        >
                            <PaginationItem>
                                <PaginationNext className={`sm:text-base ${!products?.next_page_url ? 'text-muted' : ''}`} />
                            </PaginationItem>
                        </Button>
                    </PaginationContent>
                </Pagination>
            </section>
        </AppLayout>
    );
});

export default ListHarga;
