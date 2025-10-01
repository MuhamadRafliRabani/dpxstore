import { columns } from '@/components/list-harga/columns';
import { DataTable } from '@/components/list-harga/PaginatedTable';
import AppLayout from '@/layouts/app-layout';
import { ProductType } from '@/types';
import { usePage } from '@inertiajs/react';
import { memo, useMemo } from 'react';

const ListHarga = memo(() => {
    const { products } = usePage<{ products: ProductType[] }>().props;

    const groupedByGame = useMemo(() => {
        const result: Record<number, { gameName: string; gameImage: string; items: ProductType[] }> = {};

        for (const product of products) {
            const game = product.game;
            if (!game) continue;

            if (!result[game.id]) {
                result[game.id] = {
                    gameName: game.name,
                    gameImage: game.image || '/default-image.jpg',
                    items: [],
                };
            }

            result[game.id].items.push(product);
        }

        return Object.values(result);
    }, [products]);

    return (
        <AppLayout>
            <section className="space-y-8">
                {groupedByGame.map((group, i) => (
                    <DataTable
                        key={i}
                        id={group.gameName}
                        columns={columns}
                        data={group.items}
                        title={group.gameName}
                        image={`/storage/${group.gameImage}`}
                    />
                    // <PaginatedTable key={i} columns={columns} data={group.items} title={group.gameName} image={`/storage/games/${group.gameImage}`} />
                ))}
            </section>
        </AppLayout>
    );
});

export default ListHarga;
