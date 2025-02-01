import { ReactNode } from "react";

export function SignInLayout({ children }: { children: ReactNode }) {
    return <div className="h-screen w-screen relative">{children}</div>;
}
