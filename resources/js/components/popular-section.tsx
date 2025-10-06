import { ProductPopulerType } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { useRef } from 'react';
import { Card, CardContent } from './ui/card';
import Image from './ui/loading-image';

export default function PopularSection() {
    const { product_populer } = usePage<{ product_populer: ProductPopulerType[] }>().props;
    const container = useRef<HTMLUListElement>(null);

    return (
        <section>
            <div className="px-2">
                <div className="pb-4">
                    <div className="text-primary">
                        <h3 className="text-xs leading-relaxed font-semibold tracking-wider uppercase">🔥 Favorite Products</h3>
                        <p className="text-xxs pl-6">Berikut adalah beberapa produk yang paling populer saat ini.</p>
                    </div>
                </div>

                <ul ref={container} className="flex flex-wrap gap-3">
                    {product_populer.map((item, i) => (
                        <li key={i} className="group/product-card relative flex-1">
                            <Link href={`product/games/${item.product.slug}`}>
                                <Card className="bg-order-header-background bg-accent bg-order-header-background hover:ring-primary relative w-full py-2 ring-0 hover:border-none hover:ring-1">
                                    <CardContent className="text-accent-foreground flex items-center gap-2.5 rounded-xl px-4 py-1 sm:py-2">
                                        <Image
                                            src={`/storage/${item.product.image}`}
                                            className="aspect-square size-10 rounded-md object-cover object-center"
                                        />
                                        <div className="text-xxs flex w-full flex-col">
                                            <h2 className="text-accent-foreground w-[80px] truncate font-semibold capitalize">{item.product.name}</h2>
                                            <p className="text-accent-foreground/80">{item.product.publisher}</p>
                                        </div>
                                    </CardContent>
                                </Card>
                            </Link>
                        </li>
                    ))}
                </ul>
            </div>
        </section>
    );
}
