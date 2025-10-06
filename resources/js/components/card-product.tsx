import { CardProductProps } from '@/types';
import { Link } from '@inertiajs/react';
import { memo } from 'react';

const CardProduct = memo(({ title, publisher, image, url }: CardProductProps) => {
    return (
        <Link href={url}>
            <div
                className="card group hover:border-accent-foreground bg-accent/70 relative inline-flex h-55 w-40 shrink-0 cursor-pointer justify-center overflow-hidden rounded-md shadow-md transition-transform duration-300 ease-in-out hover:scale-98 hover:border hover:shadow-lg"
                key={title}
            >
                <img src={image} className="h-full w-full" />

                <div className="bg-accent text-accent-foreground absolute right-0 bottom-0 left-0 p-2">
                    <h3 className="text-xxs font-semibold uppercase">{title}</h3>
                    <p className="text-xxs">{publisher}</p>
                </div>

                <span className="absolute top-0 left-[-75%] z-10 h-full w-[50%] rotate-12 bg-white/20 blur-lg transition-all duration-1000 ease-in-out group-hover:left-[125%]" />
                <span className="drop-shadow-3xl absolute top-0 left-0 block h-[20%] w-1/2 rounded-tl-lg transition-all duration-300" />
                <span className="drop-shadow-3xl absolute top-0 right-0 block h-[60%] w-1/2 rounded-tr-lg transition-all duration-300 group-hover:h-[90%]" />
                <span className="drop-shadow-3xl absolute bottom-0 left-0 block h-[60%] w-1/2 rounded-bl-lg transition-all duration-300 group-hover:h-[90%]" />
                <span className="drop-shadow-3xl absolute right-0 bottom-0 block h-[20%] w-1/2 rounded-br-lg transition-all duration-300" />
            </div>
        </Link>
    );
});

export default CardProduct;
