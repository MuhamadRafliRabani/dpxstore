import Image from '@/components/ui/loading-image';
import Logo from '@/components/ui/logo';
import { type SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { type PropsWithChildren } from 'react';

interface AuthLayoutProps {
    title?: string;
    description?: string;
}

export default function AuthSplitLayout({ children, title, description }: PropsWithChildren<AuthLayoutProps>) {
    const { quote } = usePage<SharedData>().props;

    return (
        <div className="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
            <div className="bg-secondary relative hidden h-full flex-col justify-between p-10 text-white lg:flex dark:border-r">
                <div className="absolute inset-0" />
                <Link href={route('home.index')} className="relative z-20 flex items-center text-lg font-medium">
                    <Logo />
                </Link>
                <Image src="/storage/website/auth-icon.png" className="max-h-130 max-w-180 object-cover" />
                {quote && (
                    <div className="relative z-20 mt-auto">
                        <blockquote className="space-y-2">
                            <p className="text-lg">&ldquo;{quote.message}&rdquo;</p>
                            <footer className="text-sm text-neutral-300">{quote.author}</footer>
                        </blockquote>
                    </div>
                )}
            </div>
            <div className="w-full lg:p-8">
                <div className="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                    <Link href={route('home.index')} className="relative z-20 flex items-center justify-center lg:hidden">
                        <Logo />
                    </Link>
                    <div className="flex flex-col items-start gap-2 text-left sm:items-center sm:text-center">
                        <h1 className="text-xl font-medium">{title}</h1>
                        <p className="text-muted text-sm text-balance">{description}</p>
                    </div>
                    {children}
                </div>
            </div>
        </div>
    );
}
