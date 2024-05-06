import { Padination } from "@/components/global/paginate";
import { UsersFilter } from "@/components/users/users-filter";
import { UsersTable } from "@/components/users/users-table";
import { getUsers } from "@/services/queries/get-users";
import { useQuery } from "@tanstack/react-query";
import { Helmet } from "react-helmet-async";
import { useSearchParams } from "react-router-dom";
import { z } from "zod";

export function Users() {
    const [searchParams, setSearchParams] = useSearchParams();

    // Recuperando valor do paramaetro de 'search';
    const search = searchParams.get("search") ?? null;

    // const page = z.coerce
    //     .number()
    //     .transform((page) => page)
    //     .parse(searchParams.get("page") ?? "1");

    const page = searchParams.get("page") ?? "1";

    const { data: users } = useQuery({
        queryKey: ["users", search, page],
        queryFn: () => getUsers({ search, page }),
    });

    if (!users) {
        return null;
    }

    function handlePaginate(pageIndex: number) {
        setSearchParams((prev) => {
            prev.set("page", pageIndex.toString());
            return prev;
        });
    }

    return (
        <div className="">
            <Helmet title="Usuários" />
            <UsersFilter />
            <UsersTable users={users.data} />
            <Padination
                pageIndex={users.current_page}
                perPage={users.per_page}
                totalCount={users.total}
                onPageChange={handlePaginate}
            />
        </div>
    );
}
