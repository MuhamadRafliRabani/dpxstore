'use client';

import { Banner } from '@/types';
import { usePage } from '@inertiajs/react';
import Autoplay from 'embla-carousel-autoplay';
import { memo, useEffect, useState } from 'react';
import { Carousel, CarouselApi, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from './ui/carousel';
import Image from './ui/loading-image';

const Carousell = memo(() => {
    const { banners } = usePage<{ banners: Banner[] }>().props;

    const [api, setApi] = useState<CarouselApi>();
    const [current, setCurrent] = useState(0);
    const [count, setCount] = useState(0);

    // autoplay plugin
    const autoplay = Autoplay({ delay: 3500, stopOnInteraction: false });

    useEffect(() => {
        if (!api) return;

        setCount(api.scrollSnapList().length);
        setCurrent(api.selectedScrollSnap());

        api.on('select', () => {
            setCurrent(api.selectedScrollSnap());
        });
    }, [api]);

    return (
        <section className="flex w-full items-center justify-center overflow-hidden">
            <div className="space-y-4">
                <Carousel setApi={setApi} opts={{ loop: true }} plugins={[autoplay]} className="carousell max-h-[70svh] overflow-hidden rounded-xl">
                    <CarouselContent>
                        {banners.map((item, index) => (
                            <CarouselItem key={index}>
                                <Image src={`/storage/${item.image}`} alt={`Slide ${index + 1}`} className="object-cover" />
                            </CarouselItem>
                        ))}
                    </CarouselContent>
                    <CarouselPrevious />
                    <CarouselNext />
                </Carousel>

                <div className="info-carousel flex items-center justify-center">
                    {/* Slide Count */}
                    <div className="text-primary/50 text-xxs whitespace-nowrap">
                        slide {current + 1} of {count}
                    </div>

                    {/* Autoplay Progress */}
                    <div className="h-1 w-30 flex-1/2 overflow-hidden rounded-full bg-black/20" hidden>
                        <div
                            key={current} // trigger reset animation
                            className="bg-primary animate-carousel-progress h-full"
                        />
                    </div>
                </div>
            </div>
        </section>
    );
});

export default Carousell;
