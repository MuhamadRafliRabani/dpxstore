import { categoriesType, ProductPopulerType } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { useRef } from 'react';
import { Card, CardContent } from './ui/card';
import Image from './ui/loading-image';

export default function PopularSection() {
    const { product_populer, categories } = usePage<{ product_populer: ProductPopulerType[]; categories: categoriesType[] }>().props;
    const container = useRef<HTMLUListElement>(null);

    return (
        <section>
            <div className="px-2">
                <div className="pb-4">
                    <div className="text-primary">
                        <h3 className="text-xs leading-relaxed font-semibold tracking-wider uppercase sm:text-sm">🔥 Favorite Products</h3>
                        <p className="text-xxs pl-6 sm:text-xs">Berikut adalah beberapa produk yang paling populer saat ini.</p>
                    </div>
                </div>

                <ul ref={container} className="grid w-full grid-cols-2 gap-4 justify-self-center sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    {product_populer.map((item, i) => {
                        const category = categories.find((cat) => cat.id == item.product.category_id);

                        if (!item.product || !category) {
                            return null;
                        }

                        return (
                            <li key={i} className="group/product-card relative grid-cols-1">
                                <Link href={`product/${category.name.toLocaleLowerCase()}/${item.product.slug}`}>
                                    <Card className="bg-order-header-background bg-accent bg-order-header-background hover:ring-primary relative w-full py-2 ring-0 hover:border-none hover:ring-1">
                                        <CardContent className="text-accent-foreground flex items-center gap-2.5 rounded-xl px-4 py-1 sm:py-2">
                                            <Image
                                                src={`/storage/${item.product.image}`}
                                                className="aspect-square size-10 rounded-md object-cover object-center sm:size-14"
                                            />
                                            <div className="text-xxs flex w-full flex-col font-semibold sm:text-xs">
                                                <h2 className="text-accent-foreground w-[80px] truncate uppercase sm:w-full">
                                                    {item.product.name.toLowerCase()}
                                                </h2>
                                                <p className="text-accent-foreground/80">{item.product.publisher}</p>
                                            </div>
                                        </CardContent>
                                    </Card>
                                </Link>
                            </li>
                        );
                    })}
                </ul>
            </div>
        </section>
    );
}
